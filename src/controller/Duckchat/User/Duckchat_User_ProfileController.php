<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 4:37 PM
 */

class Duckchat_User_ProfileController extends Duckchat_MiniProgramController
{
    private $classNameForRequest = '\Zaly\Proto\Plugin\DuckChatUserProfileRequest';
    private $classNameForResponse = '\Zaly\Proto\Plugin\DuckChatUserProfileResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Plugin\DuckChatUserProfileRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try{
            $userId = $request->getUserId();
            $userProfile = $this->getUserProfile($userId);
            if($userProfile == false) {
                throw new Exception("user is not exists");
            }
            $response = $this->getUserProfileResponse($userProfile);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==".$ex->getMessage());
            $errorCode = $this->zalyError->errorExistUser;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    private function getUserProfile($userId)
    {
        return $this->ctx->SiteUserTable->getUserByUserId($userId);
    }

    private function getUserProfileResponse($userProfile)
    {
        $allUserProfile = new \Zaly\Proto\Core\AllUserProfile();
        $publicUserProfile = $this->getPublicUserProfile($userProfile);
        $allUserProfile->setPublic($publicUserProfile);
        $allUserProfile->setTimeReg($userProfile['timeReg']);

        $response = new \Zaly\Proto\Plugin\DuckChatUserProfileResponse();
        $response->setProfile($allUserProfile);
        return $response;
    }

}