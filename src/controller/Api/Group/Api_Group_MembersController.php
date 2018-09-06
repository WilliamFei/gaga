<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 25/07/2018
 * Time: 8:43 PM
 */

class Api_Group_MembersController extends Api_Group_BaseController
{
    private $classNameForRequest   = '\Zaly\Proto\Site\ApiGroupMembersRequest';
    private $classNameForResponse  = '\Zaly\Proto\Site\ApiGroupMembersResponse';
    public $userId;

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiGroupMembersRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__."-".__FUNCTION__;

        try{
            $offset   = $request->getOffset() ? $request->getOffset() : 0;
            $pageSize = $request->getCount() > $this->defaultPageSize || !$request->getCount() ? $this->defaultPageSize : $request->getCount();
            $groupId  = $request->getGroupId();

            if (!$groupId) {
                $errorCode = $this->zalyError->errorGroupIdExists;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }

            $userMemberCount = $this->getGroupUserCount($groupId);
            $userMembers = $this->getGroupUserList($groupId, $offset, $pageSize);
            $response = $this->getApiGroupMemberResponse($userMembers, $userMemberCount);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        }catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg = " .$e->getMessage());
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    private function getApiGroupMemberResponse($userMembers, $userMemberCount)
    {
        $response = new \Zaly\Proto\Site\ApiGroupMembersResponse();
        $response->setTotalCount($userMemberCount);
        $list = [];
        foreach ($userMembers as $user) {
            $list[] = $this->getGroupMemberUserProfile($user);
        }
        $response->setList($list);
        return $response;
    }
}