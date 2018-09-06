<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 4:29 PM
 */

class Duckchat_Group_CheckMemberController extends Duckchat_MiniProgramController
{
    private $classNameForRequest = '\Zaly\Proto\Plugin\DuckChatGroupCheckMemberRequest';
    private $classNameForResponse = '\Zaly\Proto\Plugin\DuckChatGroupCheckMemberResponse';
    private $logoutAction = "api.site.logout";

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Plugin\DuckChatGroupCheckMemberRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;

        try {
            $groupId = $request->getGroupId();
            $userId = $request->getUserId();
            $memberType = $this->getMemberType($groupId, $userId);
            $response = $this->getGroupCheckMemberResponse($memberType);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());
            $errorCode = $this->zalyError->errorExistUser;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }

    }

    private function getMemberType($groupId, $userId)
    {
        $groupUserInfo = $this->ctx->SiteGroupUserTable->getGroupUser($groupId, $userId);
        if ($groupUserInfo == false) {
            throw new Exception("none user");
        }
        return $groupUserInfo['memberType'];
    }

    private function getGroupCheckMemberResponse($memberType)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;

        try {
            $response = new \Zaly\Proto\Plugin\DuckChatGroupCheckMemberResponse();
            $response->setMemberType($memberType);
            return $response;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());

        }
    }
}