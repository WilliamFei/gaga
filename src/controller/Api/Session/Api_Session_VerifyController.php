<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 23/08/2018
 * Time: 7:17 PM
 */


class Api_Session_VerifyController extends BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Platform\ApiSessionVerifyRequest';
    private $classNameForResponse = '\Zaly\Proto\Platform\ApiSessionVerifyResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    public function rpcResponseClassName()
    {
        return $this->classNameForResponse;
    }

    /**
     * @param \Zaly\Proto\Platform\ApiSessionVerifyRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        try {
            $preSessionId = $request->getPreSessionId();
            $errorCode = $this->zalyError->errorPreSessionId;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            if (!$preSessionId) {
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception("401 ");
            }
            ////TODO 临时存储，切换到redis

            $userInfo = $this->ctx->PassportPasswordPreSessionTable->getInfoByPreSessionId($preSessionId);

            if (!$userInfo || !$userInfo['userId']) {
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }

            $response = $this->buildApiSessionVerifyResponse($userInfo);

            $this->ctx->PassportPasswordPreSessionTable->delInfoByPreSessionId($preSessionId);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->info($tag, " error_msg=" . $ex->getMessage());
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    private function buildApiSessionVerifyResponse($userInfo)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        try {
            $sitePubkPem = base64_decode($userInfo['sitePubkPem']);
            $nickname = $userInfo['nickname'];

            $userId = sha1($userInfo['userId'] . "@" . $sitePubkPem);
            $userProfile = new \Zaly\Proto\Platform\LoginUserProfile();
            $userProfile->setUserId($userId);
            $userProfile->setLoginName($userInfo['loginName']);
            $userProfile->setNickName($nickname);
            $userProfile->setInvitationCode($userInfo['invitationCode']);
            $loginUserProfileKey = $this->generateStrKey();
            $key = $this->ctx->ZalyRsa->encrypt($loginUserProfileKey, $sitePubkPem);
            $aesStr = $this->ctx->ZalyAes->encrypt(serialize($userProfile), $loginUserProfileKey);

            $this->ctx->Wpf_Logger->info("site: api.session.verify", "profile=" . json_encode($userProfile));

            $response = new \Zaly\Proto\Platform\ApiSessionVerifyResponse();
            $response->setKey($key);
            $response->setEncryptedProfile($aesStr);
            return $response;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->info($tag, " error_msg=" . $ex);
            throw new Exception("get response failed");
        }
    }

    private function generateStrKey($length = 16, $strParams = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            $length = 16;
        }

        $str = '';
        for ($i = $length; $i > 0; $i--) {
            $str .= $strParams[mt_rand(0, strlen($strParams) - 1)];
        }

        return $str;
    }
}