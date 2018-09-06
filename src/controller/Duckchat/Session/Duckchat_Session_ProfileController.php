<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 04/09/2018
 * Time: 4:27 PM
 */

class Duckchat_Session_ProfileController extends Duckchat_MiniProgramController
{
    private $classNameForRequest = '\Zaly\Proto\Plugin\DuckChatSessionProfileRequest';
    private $classNameForResponse = '\Zaly\Proto\Plugin\DuckChatSessionProfileResponse';
    private $requestAction = "duckchat.session.profile";

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Plugin\DuckChatSessionProfileRequest $request
     * @param \Zaly\Proto\Core\TransportData $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {

        try {
            $encryptedSessionId = $request->getEncryptedSessionId();
            $pluginId = $request->getPluginId();
            $pluginProfile = $this->getPluginProfile($pluginId);


            if (empty($encryptedSessionId)) {
                throw new Exception("encrypted sessionId is empty");
            }

            $authKey = $pluginProfile['authKey'];
            if (empty($authKey)) {
                $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_PLUGIN_PLBLIC_KEY);
                $authKey = $config[SiteConfig::SITE_PLUGIN_PLBLIC_KEY];
            }

            $sessionId = $this->ctx->ZalyRsa->decrypt($encryptedSessionId, $authKey);


            //sessionId -> userId
            $sessionInfo = $this->ctx->SiteSessionTable->getSessionInfoBySessionId($this->$sessionId);
            if (!$sessionInfo) {
                $this->ctx->Wpf_Logger->info($this->requestAction, "session  info is null , session id = " . $this->sessionId);
                $errorCode = $this->zalyError->errorSession;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                $this->rpcReturn($this->action, null);
                die();
            }


            $userId = $sessionInfo['userId'];
            $userProfile = $this->ctx->SiteUserTable->getUserByUserId($userId);

            $response = $this->buildRequestResponse($userProfile);

            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($this->requestAction, $response);
        } catch (Exception $e) {
            $this->setRpcError("error.alert", $e->getMessage());
            $this->ctx->Wpf_Logger->error($this->requestAction, $e);
        }
        $this->rpcReturn($this->requestAction, $response);
        return;
    }

    private function getPluginProfile($pluginId)
    {
        return $this->ctx->SitePluginTable->getPluginById($pluginId);
    }


    private function buildRequestResponse($userProfile)
    {
        $publicProfile = new \Zaly\Proto\Core\PublicUserProfile();
        $publicProfile->setUserId($userProfile['userId']);
        $publicProfile->setAvatar(isset($userProfile['avatar']) ? $userProfile['avatar'] : "");
        $publicProfile->setLoginname($userProfile['loginName']);
        $publicProfile->setNickname($userProfile['nickname']);
        $publicProfile->setNicknameInLatin($userProfile['nicknameInLatin']);

        if (isset($userProfile['availableType'])) {
            $publicProfile->setAvailableType($userProfile['availableType']);
        } else {
            $publicProfile->setAvailableType(\Zaly\Proto\Core\UserAvailableType::UserAvailableNormal);
        }

        $profile = new Zaly\Proto\Core\AllUserProfile();
        $profile->setPublic($publicProfile);
        $profile->setTimeReg($userProfile['timeReg']);

        $response = new Zaly\Proto\Plugin\DuckChatSessionProfileResponse();
        $response->setProfile($profile);

        return $response;
    }
}