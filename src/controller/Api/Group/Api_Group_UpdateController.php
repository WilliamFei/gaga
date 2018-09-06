<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 25/07/2018
 * Time: 2:39 PM
 */
class Api_Group_UpdateController extends Api_Group_BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiGroupUpdateRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiGroupUpdateResponse';

    public $userId;
    public $defaultMaxGroupMembers = -1;
    private $groupNameLength = 20;

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiGroupUpdateRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__."-".__FILE__;
        try{
            $groupId = $request->getGroupId();
            if(!$groupId) {
                $errorCode = $this->zalyError->errorGroupProfile;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }
            $values = $request->getValues();
            $this->handleValues($values, $groupId);
            $response = $this->getApiGroupUpdateResponse($groupId);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        }catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg =". $e->getMessage());
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    private function handleValues($values, $groupId)
    {

        try{
            $tag = __CLASS__."-".__FUNCTION__;
            $this->pinyin    =  new \Overtrue\Pinyin\Pinyin();

            $updateValues = [];
            $adminUserIds = [];
            $speakUserIds = [];
            $isMuteValues = [];
            foreach ($values as $v) {
                $updateType = $v->getType();
                $this->ctx->Wpf_Logger->info($tag, " group profile updateType  =". $updateType);
                switch ($updateType){
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateName:
                        $name = $v->getName();
                        $groupName = trim($name);
                        $this->ctx->Wpf_Logger->error($tag, " group profile groupName  =". $groupName);
                        if(mb_strlen($groupName) > $this->groupNameLength || mb_strlen($groupName)<1) {
                            $errorCode = $this->zalyError->errorGroupNameLength;
                            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                            $this->setRpcError($errorCode, $errorInfo);
                            throw new Exception($errorInfo);
                        }
                        $updateValues['name'] = $groupName;
                        $nameInLatin = $this->pinyin->permalink($groupName, "");
                        $updateValues['nameInLatin'] = $nameInLatin;
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateIsMute:
                        $mute = $v->getIsMute() ? 1 : 0 ;
                        $isMuteValues['isMute'] = $mute;
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdatePermissionJoin :
                        $permissionJoin = $v->getPermissionJoin();
                        $updateValues['permissionJoin'] = $permissionJoin;
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateCanGuestReadMessage:
                        $canGuestReadMessage = $v->getCanGuestReadMessage();
                        $updateValues['canGuestReadMessage'] = $canGuestReadMessage;
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateDescription:
                        $description = $v->getDescription();
                        $updateValues["description"] = $description->getBody();
                        $updateValues['descriptionType'] = $description->getType();
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateAdmin:
                        $writeType = $v->getWriteType();
                        foreach($v->getAdminUserIds() as $userId ) {
                            $adminUserIds[$writeType][] = $userId;
                        }
                        break;
                    case \Zaly\Proto\Site\ApiGroupUpdateType::ApiGroupUpdateSpeaker:
                        $writeType  = $v->getWriteType();
                        foreach($v->getSpeakerUserIds() as $userId ) {
                            $speakUserIds[$writeType][] = $userId;
                        }
                        break;
                }
            }
            if($isMuteValues) {
                $where = [
                    "groupId" => $groupId,
                    "userId"  => $this->userId,
                ];
                $this->ctx->Wpf_Logger->error($tag, " isMute  =". json_encode($isMuteValues));

                $this->ctx->SiteGroupUserTable->updateGroupUserInfo($where, $isMuteValues);
            }

            $this->ctx->Wpf_Logger->error($tag, " group profile adminUserIds  =". json_encode($adminUserIds));
            $this->ctx->Wpf_Logger->error($tag, " group profile speakUserIds  =".json_encode($speakUserIds));
            $this->ctx->Wpf_Logger->error($tag, " group profile updateValues  =". json_encode($updateValues));

            if(!$adminUserIds && !$speakUserIds && !$updateValues) {
                return;
            }
            //只有群主管理员可以修改
            $this->isGroupAdmin($groupId);

            $groupInfo = $this->getGroupProfile($groupId);

            if(count($adminUserIds)) {
                $this->isGroupOwner($groupId);
                foreach($adminUserIds as $writeType => $userIds) {
                    switch ($writeType){
                        case \Zaly\Proto\Core\DataWriteType::WriteAdd:
                            $userIds      = $adminUserIds[\Zaly\Proto\Core\DataWriteType::WriteAdd];
                            $memberType   = \Zaly\Proto\Core\GroupMemberType::GroupMemberAdmin;
                            $resultUserId = array_diff($userIds, [$groupInfo['owner']]);
                            $resultUserId = array_values($resultUserId);
                            $resultUserId = array_unique($resultUserId);
                            $this->ctx->SiteGroupUserTable->addMemberRole($resultUserId, $groupId, $memberType);
                            break;
                        case \Zaly\Proto\Core\DataWriteType::WriteUpdate:
                            $userIds          = $adminUserIds[\Zaly\Proto\Core\DataWriteType::WriteUpdate];
                            $resultUserId     = array_diff($userIds, [$groupInfo['owner']]);
                            $adminMemberType  = \Zaly\Proto\Core\GroupMemberType::GroupMemberAdmin;
                            $nomalMemberType  = \Zaly\Proto\Core\GroupMemberType::GroupMemberNormal;
                            $ownerMemberType  = \Zaly\Proto\Core\GroupMemberType::GroupMemberOwner;
                            $resultUserId     = array_values($resultUserId);
                            $resultUserId = array_unique($resultUserId);
                            $this->ctx->SiteGroupUserTable->updateMemberRole($resultUserId, $groupId, $adminMemberType, $nomalMemberType, $ownerMemberType);
                            break;
                        case \Zaly\Proto\Core\DataWriteType::WriteDel:
                            $userIds      = $adminUserIds[\Zaly\Proto\Core\DataWriteType::WriteDel];
                            $memberType   = \Zaly\Proto\Core\GroupMemberType::GroupMemberNormal;
                            $resultUserId = array_diff($userIds, [$groupInfo['owner']]);
                            $resultUserId = array_values($resultUserId);
                            $resultUserId = array_unique($resultUserId);

                            $this->ctx->SiteGroupUserTable->removeMemberRole($resultUserId, $groupId, $memberType);
                            break;
                    }
                }
            }
            $speakUserIdStr = "";
            if(count($speakUserIds)) {
                $speakers = (isset($groupInfo['speakers']) && $groupInfo['speakers'] != "")
                    ? json_decode($groupInfo['speakers'], true)
                    : [];
                foreach($speakUserIds as $writeType => $userIds) {
                    switch ($writeType){
                        case \Zaly\Proto\Core\DataWriteType::WriteAdd:
                            $userIds  = $speakUserIds[\Zaly\Proto\Core\DataWriteType::WriteAdd];
                            $speakers = array_merge($speakers, $userIds);
                            $speakers = array_unique($speakers);
                            $speakUserIdStr = json_encode($speakers);
                            break;
                        case \Zaly\Proto\Core\DataWriteType::WriteUpdate:
                            $userIds = $speakUserIds[\Zaly\Proto\Core\DataWriteType::WriteUpdate];
                            $speakers = array_unique($speakers);
                            $speakUserIdStr = json_encode($userIds);
                            break;
                        case \Zaly\Proto\Core\DataWriteType::WriteDel:
                            $userIds = $speakUserIds[\Zaly\Proto\Core\DataWriteType::WriteDel];
                            $speakers = array_diff($speakers, $userIds);
                            $speakers = array_unique($speakers);
                            $speakUserIdStr = json_encode($speakers);
                            break;
                    }
                }
            }
            $where = [
                "groupId" => $groupId
            ];
            $updateData = [];
            if($updateValues) {
                $updateData = array_merge($updateData, $updateValues);
            }
            if(strlen($speakUserIdStr)) {
                $updateData['speakers'] = $speakUserIdStr;
            }
            $this->ctx->Wpf_Logger->error($tag, " group profile update values  =". json_encode($updateData));

            if(!count($updateData)) {
                return ;
            }
            $this->ctx->SiteGroupTable->updateGroupInfo($where, $updateData);

        }catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg =". $e->getMessage());
            $errorCode = $this->zalyError->errorGroupUpdate;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            throw new Exception($errorInfo);
        }
    }

    private function getApiGroupUpdateResponse($groupId)
    {
        $groupInfo = $this->getGroupProfile($groupId);
        $isMute = isset($groupInfo['isMute']) && $groupInfo['isMute'] == 1 ? 1 : 0 ;
        $publicGroupProfile = $this->getPublicGroupProfile($groupInfo);

        $response = new \Zaly\Proto\Site\ApiGroupUpdateResponse();
        $response->setProfile($publicGroupProfile);
        $response->setIsMute($isMute);
        $response->setMemberType($groupInfo['memberType']);

        $response->setIsMute($groupInfo['isMute']);
        return $response;
    }
}