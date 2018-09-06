<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 03/08/2018
 * Time: 5:21 PM
 */

class Api_User_UpdateController extends BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiUserUpdateRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiUserUpdateResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiUserUpdateRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;

        $response = new \Zaly\Proto\Site\ApiUserUpdateResponse();
        try {
            $userId = $this->userId;
            $values = $request->getValues();

            $this->updateUserProfile($userId, $values);

            $userProfile = $this->getUserProfileResponse($userId);
            $response->setProfile($userProfile);

            $this->setRpcError($this->defaultErrorCode, "");
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, $ex);
            $errorCode = $this->zalyError->errorFriendUpdate;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError("error.update.user.profile", $errorInfo);
        }
        $this->rpcReturn($transportData->getAction(), $response);
    }

    /**
     * @param string $userId
     * @param array $values
     */
    private function updateUserProfile($userId, $values)
    {
        $updateData = [];
        foreach ($values as $v) {
            $type = $v->getType();
            switch ($type) {
                case \Zaly\Proto\Site\ApiUserUpdateType::ApiUserUpdateAvatar:
                    //update user avatar
                    $avatar = $v->getAvatar();
                    $updateData['avatar'] = $avatar;
                    break;
                case \Zaly\Proto\Site\ApiUserUpdateType::ApiUserUpdateNickname:
                    //update user name
                    $nickName = $v->getNickname();
                    $updateData['nickname'] = $nickName;
                    $pinyin = new \Overtrue\Pinyin\Pinyin();
                    $updateData['nicknameInLatin'] = $pinyin->permalink($nickName, "");
                    break;
            }
        }
        $where = [
            "userId" => $userId
        ];
        $this->ctx->SiteUserTable->updateUserData($where, $updateData);
    }


    protected function getUserProfileResponse($userId)
    {
        $profile = $this->getUserSelfProfile($userId);

        if (!empty($profile)) {

            $publicProfile = new Zaly\Proto\Core\PublicUserProfile();
            $publicProfile->setUserId($profile['userId']);
            $publicProfile->setAvatar($profile['avatar']);
            $publicProfile->setLoginName($profile['loginName']);
            $publicProfile->setNickname($profile['nickname']);
            $publicProfile->setNicknameInLatin($profile['nicknameInLatin']);
            $publicProfile->setRealNickname($profile['nickname']);

            if ($profile['availableType']) {
                $publicProfile->setAvailableType($profile['availableType']);
            } else {
                $publicProfile->setAvailableType(\Zaly\Proto\Core\UserAvailableType::UserAvailableNormal);
            }

            $AllUserProfile = new \Zaly\Proto\Core\AllUserProfile();
            $AllUserProfile->setPublic($publicProfile);
            $AllUserProfile->setTimeReg($profile['timeReg']);

            return $AllUserProfile;
        }

        return null;
    }

    protected function getUserSelfProfile($userId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            return $this->ctx->SiteUserTable->getUserByUserId($userId);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, e);
        }
        return [];
    }
}