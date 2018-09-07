<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 13/07/2018
 * Time: 6:32 PM
 */

use Google\Protobuf\Any;
use Zaly\Proto\Core\TransportData;
use Zaly\Proto\Core\TransportDataHeaderKey;
use Google\Protobuf\Internal\Message;

abstract class MiniProgramController extends \Wpf_Controller
{
    protected $logger;

    protected $userId;
    protected $userInfo;
    protected $sessionId;
    protected $success = "success";
    protected $error = "error.alert";

    protected $ctx;

    protected $language = Zaly\Proto\Core\UserClientLangType::UserClientLangEN;
    protected $requestData;

    public function __construct(Wpf_Ctx $context)
    {
        $this->ctx = new BaseCtx();
        $this->logger = new Wpf_Logger();
    }

    protected abstract function doRequest();

    protected abstract function getMiniProgramId();

    /**
     * 根据http request cookie中的duckchat_sessionId 做权限判断
     * @return string|void
     */
    public function doIndex()
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;

        try {
            parent::doIndex();

            // 接收的数据流
            $this->requestData = file_get_contents("php://input");

            $this->logger->info("site.manage.base", "cookie=" . json_encode($_COOKIE));

            $duckchatSessionId = $_COOKIE["duckchat_sessionid"];

            if (empty($duckchatSessionId)) {
                throw new Exception("duckchat_sessionid is empty in cookie");
            }
            $miniProgramId = $this->getMiniProgramId();

            //get user profile from duckchat_sessionid
            $userPublicProfile = $this->getDuckChatUserProfileFromSessionId($duckchatSessionId, $miniProgramId);

            if (empty($userPublicProfile) || empty($userPublicProfile->getUserId())) {
                throw new Exception("get empty user profile by duckchat_sessionid error");
            }

            $this->userId = $userPublicProfile->getUserId();
            $this->ctx->Wpf_Logger->info("", "---------------UserID=" . $this->userId);

            if (!$this->ctx->Site_Config->isManager($this->userId)) {
                //不是管理员，exception
                throw new Exception("user has no permission");
            }

            $this->getAndSetClientLang();

            $this->doRequest();
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error msg =" . $ex);
            //echo permission page
            $this->showPermissionPage();
        }
    }

    /**
     * @param $duckchatSessionId
     * @return \Zaly\Proto\Core\PublicUserProfile
     * @throws Exception
     */
    public function getDuckChatUserProfileFromSessionId($duckchatSessionId, $miniProgramId)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        try {

            //$duckchatSessionId
            //可以本地解析sessionId，为了逻辑一致，直接http远程获取
            $response = $this->requestDuckChatSessionProfile($duckchatSessionId, $miniProgramId);

            if (empty($response)) {
                throw new Exception("get empty response by duckchat_sessionid error");
            }

            $userProfile = $response->getProfile();
            return $userProfile->getPublic();
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error msg =" . $ex);
            throw $ex;
        }
    }

    /**
     * @param $duckchatSessionid
     * @return bool|Zaly\Proto\Plugin\DuckChatSessionProfileResponse
     */
    private function requestDuckChatSessionProfile($duckchatSessionid, $miniProgramId)
    {
        $requestData = new Zaly\Proto\Plugin\DuckChatSessionProfileRequest();

        $requestData->setEncryptedSessionId($duckchatSessionid);
        $duckChatAction = "duckchat.session.profile";
        try {
            $siteAddress = ZalyConfig::getConfig("siteAddress");
            $requestUrl = $siteAddress . "/?action=" . $duckChatAction . "&body_format=pb&miniProgramId=" . $miniProgramId;

            $this->ctx->Wpf_Logger->info($duckChatAction, "http request url =" . $requestUrl);

            $httpResponse = $this->ctx->ZalyCurl->requestWithActionByPb($duckChatAction, $requestData, $requestUrl, 'post');

            return $this->buildResponseFromHttp($requestUrl, $httpResponse);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($duckChatAction, $e);
        }

        return false;
    }

    private function buildResponseFromHttp($url, $httpResponse)
    {
        $urlParams = parse_url($url);
        $query = isset($urlParams['query']) ? $urlParams['query'] : [];
        $urlParams = $this->ctx->ZalyCurl->convertUrlQuery($query);
        $requestAction = $urlParams['action'];
        $responseBodyFormat = $urlParams['body_format'];

        if (empty($requestAction)) {
            throw new Exception("request url with no action");
        }

        if (empty($responseBodyFormat)) {
            $responseBodyFormat = 'json';
        }

        $responseTransportData = new Zaly\Proto\Core\TransportData();
        switch ($responseBodyFormat) {
            case "json":
                $responseTransportData->mergeFromJsonString($httpResponse);
                break;
            case "pb":
                $responseTransportData->mergeFromString($httpResponse);
                break;
            case "base64pb":
                $realData = base64_decode($httpResponse);
                $responseTransportData->mergeFromString($realData);
                break;
        }

        if ($requestAction != $responseTransportData->getAction()) {
            throw new Exception("response with error action");
        }

        $responseHeader = $responseTransportData->getHeader();

        if (empty($responseHeader)) {
            throw new Exception("response with empty header");
        }

        $errCode = $this->getHeaderValue($responseHeader, TransportDataHeaderKey::HeaderErrorCode);

        if ("success" == $errCode) {
            $responseMessage = $responseTransportData->getBody()->unpack();
            return $responseMessage;
        } else {
            $errInfo = $this->getHeaderValue($responseHeader, TransportDataHeaderKey::HeaderErrorInfo);
            throw new Exception($errInfo);
        }

    }

    private function getHeaderValue($header, $key)
    {
        if (empty($header)) {

        }
        return $header['_' . $key];
    }

    public function showPermissionPage()
    {
        $apiPageLogin = ZalyConfig::getConfig("apiPageLogin");
        header("Location:" . $apiPageLogin);
        exit();
    }

    // no use
    public function setCookieBase64($userId)
    {
        $cookieAes = $this->ctx->ZalyAes->encrypt($userId, $this->ctx->ZalyAes->cookieKey);
        $cookieBase64 = base64_encode($cookieAes);
        setcookie("zaly_site_user", $cookieBase64, time() + $this->sessionIdTimeOut, "/", "", false, true);
    }

    protected function getAndSetClientLang()
    {
        $headLang = $_GET['lang'];

        if (isset($headLang) && $headLang == Zaly\Proto\Core\UserClientLangType::UserClientLangZH) {
            $this->language = Zaly\Proto\Core\UserClientLangType::UserClientLangZH;
        }
    }

}