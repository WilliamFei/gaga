cd<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 18/07/2018
 * Time: 8:32 AM
 */


class Api_Site_LoginController extends \BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiSiteLoginRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiSiteLoginResponse';
    private $sessionVerifyAction = "api.session.verify";
    private $pinyin;

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiSiteLoginRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        ///处理request，
        $tag = __CLASS__ . '-' . __FUNCTION__;
        try {
            $loginName = $request->getLoginName();
            $userExists = $this->checkUserExists($loginName);
            $isRegister = $request->getIsRegister();
            $this->ctx->Wpf_Logger->info("api.site.login", " =========userExists=" . $userExists);

            if (!$userExists && $isRegister == false) {
                $errorCode = $this->zalyError->errorUserNeedRegister;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
                return;
            }

            $preSessionId = $request->getPreSessionId();
            $devicePubkPem = trim($request->getDevicePubkPem());

            if (empty($preSessionId) || empty($devicePubkPem)) {
                throw new Exception("with error parameters");
            }

            $this->ctx->Wpf_Logger->info("api.site.login", " =========preSessionId=" . $preSessionId);
//            $this->ctx->Wpf_Logger->info("api.site.login", " -devicePubkPem=" . $devicePubkPem);

            if (!$preSessionId) {
                $errorCode = $this->zalyError->errorSession;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }

            //get user profile from platform
            $userProfile = $this->ctx->Site_Login->checkPreSessionIdFromPlatform($preSessionId, $devicePubkPem);

            $realSessionId = $userProfile['sessionId'];
            $this->ctx->Wpf_Logger->info("api.site.login", "get platform sessionid=" . $realSessionId);

            $response = $this->buildApiSiteLoginResponse($userProfile, $realSessionId);


            $this->ctx->Wpf_Logger->info("api.site.login", "response=" . $response->serializeToJsonString());

            //back to request
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        } catch (Exception $ex) {
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->ctx->Wpf_Logger->error($tag, "=========error=" . $ex->getMessage());

            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }

        return;
    }

    private function buildApiSiteLoginResponse($userInfo, $sessionId)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;

        try {
            $publicUserProfile = $this->getPublicUserProfile($userInfo);

            if (\Zaly\Proto\Core\UserAvailableType::UserAvailableBlocked == $publicUserProfile->getAvailableType()) {
                throw new Exception("user is blocked");
            }

            $allUserProfile = new \Zaly\Proto\Core\AllUserProfile();
            $allUserProfile->setPublic($publicUserProfile);

            $response = new \Zaly\Proto\Site\ApiSiteLoginResponse();
            $response->setProfile($allUserProfile);
            $response->setSessionId($sessionId);
            return $response;
        } catch (Exception $ex) {
            $errorCode = $this->zalyError->errorSiteLogin;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            throw new Exception("response is fail");
        }
    }

    private function checkUserExists($loginName)
    {
        try {
            $user = $this->ctx->SiteUserTable->getUserByLoginName($loginName);

            if ($user) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error("api.site.login", "error_msg=" . $ex->getMessage());
            return false;
        }
    }
}

