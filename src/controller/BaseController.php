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

abstract class BaseController extends \Wpf_Controller
{
    protected $httpHeader = ["KeepSocket" => true];
    protected $headers = [];
    protected $bodyFormatType;
    protected $bodyFormatArr = [
        "json",
        "pb",
        "base64pb"
    ];
    protected $defaultBodyFormat = "json";
    protected $action = '';
    protected $requestTransportData;
    private $whiteAction = [
        "api.site.config",
        "api.site.login",
        "im.cts.ping",
        "api.passport.passwordReg",
        "api.passport.passwordLogin",
        "api.session.verify",
        "api.passport.passwordFindPassword",
        "api.passport.passwordResetPassword",
        "api.plugin.proxy",
    ];
    protected $sessionIdTimeOut = 36000000; //10个小时的毫秒
    protected $userId;
    protected $sessionId;
    protected $deviceId;
    protected $userInfo;
    public $defaultErrorCode = "success";
    public $defaultPageSize = 200;
    public $defaultPage = 1;
    public $errorSiteInit = "error.site.init";

    protected $language = Zaly\Proto\Core\UserClientLangType::UserClientLangEN;

    /**
     * @var BaseCtx
     */
    protected $ctx;

    // return the name for parse json to Any.
    abstract public function rpcRequestClassName();

    // waiting for son~
    abstract public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData);

    /**
     * 设置transData header
     * @param $key
     * @param $val
     */
    public function setTransDataHeaders($key, $val)
    {
        $key = "_{$key}";
        $this->headers[$key] = $val;
    }

    public function keepSocket()
    {
        header("KeepSocket: true");
    }

    public function setRpcError($errorCode, $errorInfo)
    {
        $this->setTransDataHeaders(TransportDataHeaderKey::HeaderErrorCode, $errorCode);
        $this->setTransDataHeaders(TransportDataHeaderKey::HeaderErrorInfo, $errorInfo);
    }

    public function getRpcError()
    {
        return $this->headers[TransportDataHeaderKey::HeaderErrorCode];
    }

    public function getRequestAction()
    {
        return $this->action;
    }

    /**
     * 返回需要格式的数据
     * @param $action
     * @param \Google\Protobuf\Internal\Message $response
     */
    public function rpcReturn($action, $response)
    {
        $transData = new TransportData();
        $transData->setAction($action);

        if (null != $response) {
            $anyBody = new Any();
            $anyBody->pack($response);
            $transData->setBody($anyBody);
        }

        $transData->setHeader($this->headers);
        $transData->setPackageId($this->requestTransportData->getPackageId());

        $body = "";
        if ("json" == $this->bodyFormatType) {
            $body = $transData->serializeToJsonString();
            $body = trim($body);
        } elseif ("pb" == $this->bodyFormatType) {
            $body = $transData->serializeToString();
        } elseif ("base64pb" == $this->bodyFormatType) {
            $body = $transData->serializeToString();
            $body = base64_encode($body);
        } else {
            return;
        }
        echo $body;
    }

    // ignore.~
    public function __construct(Wpf_Ctx $context)
    {
        if (!$this->checkDBIsExist()) {
            $this->action = $_GET['action'];
            $this->requestTransportData = new \Zaly\Proto\Core\TransportData();
            $this->setRpcError($this->errorSiteInit, ZalyConfig::getApiPageSiteInit());
            $this->bodyFormatType = isset($_GET['body_format']) ? $_GET['body_format'] : "";
            $this->bodyFormatType = strtolower($this->bodyFormatType);
            if (!in_array($this->bodyFormatType, $this->bodyFormatArr)) {
                $this->bodyFormatType = $this->defaultBodyFormat;
            }
            $this->rpcReturn($this->action, null);
            exit();
        }
        $this->ctx = new BaseCtx();
    }

    /**
     * 处理方法， 根据bodyFormatType, 获取transData
     * @return string|void
     */
    public function doIndex()
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;

        parent::doIndex();

        $this->ctx = new BaseCtx();

        // 判断请求格式 json， pb, pb64
        // body_format 只从$_GET中接收
        $this->action = $_GET['action'];
//        $this->checkDBCanWrite();

        $this->bodyFormatType = isset($_GET['body_format']) ? $_GET['body_format'] : "";
        $this->bodyFormatType = strtolower($this->bodyFormatType);

        if (!in_array($this->bodyFormatType, $this->bodyFormatArr)) {
            $this->bodyFormatType = $this->defaultBodyFormat;
        }

        // 接收的数据流
        $reqData = file_get_contents("php://input");


        // 将数据转为TransportData
        $this->requestTransportData = new \Zaly\Proto\Core\TransportData();

        if (!ZalyHelper::checkOpensslEncryptExists()) {
            $this->ctx->Wpf_Logger->error($tag, "none has openssl function exists");
            // disabled the rpcReturn online.
            $this->setRpcError("error.proto.parse", "openssl_encrypt is not exists");
            $this->rpcReturn($this->action, null);
            die();
        }

        ////判断 request proto 类 是否存在。
        $requestClassName = $this->rpcRequestClassName();
        if (class_exists($requestClassName, true)) {
            $usefulForProtobufAnyParse = new $requestClassName();
        } else {
            trigger_error("no request proto class: " . $requestClassName, E_USER_ERROR);
            die();
        }
        try {

            if ("json" == $this->bodyFormatType) {
                if (empty($reqData)) {
                    $reqData = "{}";
                }
                $this->requestTransportData->mergeFromJsonString($reqData);
            } elseif ("pb" == $this->bodyFormatType) {
                $this->requestTransportData->mergeFromString($reqData);
            } elseif ("base64pb" == $this->bodyFormatType) {
                $realData = base64_decode($reqData);
                $this->requestTransportData->mergeFromString($realData);
            }

        } catch (Exception $e) {
            $error = sprintf("parse proto error, format: %s, error: %s", $this->bodyFormatType, $e->getMessage());
            $this->ctx->Wpf_Logger->error($tag, $error);
            // disabled the rpcReturn online.
            $this->setRpcError("error.proto.parse", $error);
            $this->rpcReturn($this->action, null);
            die();
        }
        $requestMessage = $usefulForProtobufAnyParse;
        ////解析请求数据，
        ///
        if (null !== $this->requestTransportData->getBody()) {
            $requestMessage = $this->requestTransportData->getBody()->unpack();
        }

        // $this->ctx->Wpf_Logger->error($tag, "request  packageId =" . $this->requestTransportData->getPackageId());
        $this->handleHeader();

        $this->getAndSetClientLang();
        $this->getZalyErrorLang();

        $this->checkSessionId($this->action);
        $this->rpc($requestMessage, $this->requestTransportData);
    }

    private function handleHeader()
    {
        $headers = $this->requestTransportData->getHeader();

        foreach ($headers as $key => $val) {
            $key = str_replace("_", "", $key);
            $headers[$key] = $val;
        }
        $this->requestTransportData->setHeader($headers);
    }

    /**
     * @param Message $transportData
     * @return string
     */
    public function getSessionId(\Google\Protobuf\Internal\Message $transportData)
    {
        $header = $transportData->getHeader();
        $sessionId = $header[TransportDataHeaderKey::HeaderSessionid];
        return $sessionId;
    }

    public function checkSessionId($action)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        // $this->ctx->Wpf_Logger->error($tag, "check session id ");
        $requestTransportData = $this->requestTransportData;
        $headers = $requestTransportData->getHeader();
        if (in_array($action, $this->whiteAction)) {
            return;
        }
//        // $headers[TransportDataHeaderKey::HeaderSessionid] = "6a578fd6-fb5e-4a98-a903-ce1ffa7da1d2";
        if (!isset($headers[TransportDataHeaderKey::HeaderSessionid])) {
            $this->ctx->Wpf_Logger->error($tag, "session is null ");
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($this->action, null);
            die();
        }
        $this->sessionId = $headers[TransportDataHeaderKey::HeaderSessionid];

        $sessionInfo = $this->ctx->SiteSessionTable->getSessionInfoBySessionId($this->sessionId);
        if (!$sessionInfo) {
            $this->ctx->Wpf_Logger->error($tag, "session  info is null , session id = " . $this->sessionId);
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($this->action, null);
            die();
        }
        $timeActive = $sessionInfo['timeActive'];
        $nowTime = $this->ctx->ZalyHelper->getMsectime();

        ///TODO 临时屏蔽 sessionId 时间过期

        $this->ctx->Wpf_Logger->info("sessionTime", "session nowtime=" . $nowTime);
        $this->ctx->Wpf_Logger->info("sessionTime", "session timeActive=" . $timeActive);
        $this->ctx->Wpf_Logger->info("sessionTime", "session sessonTimeOut=" . $this->sessionIdTimeOut);
        $this->ctx->Wpf_Logger->info("sessionTime", "(nowTime - timeActive) > sessionIdTimeOut" . (($nowTime - $timeActive) > $this->sessionIdTimeOut) ? 1 : 0);

//        if (($nowTime - $timeActive) > $this->sessionIdTimeOut) {
//            $this->ctx->Wpf_Logger->error($tag, "session  time out  , session id = " . $sessionId);
//
//            $errorCode = $this->zalyError->errorSession;
//            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
//            $this->setRpcError($errorCode, $errorInfo);
//            $this->rpcReturn($this->action, null);
//            die();
//        }
        $this->userId = $sessionInfo['userId'];
        $this->deviceId = $sessionInfo['deviceId'];
        $this->userInfo = $this->ctx->SiteUserTable->getUserByUserId($this->userId);
        if (!$this->userInfo) {
            $this->ctx->Wpf_Logger->error($tag, "user is null  , session id = " . $this->sessionId);
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($this->action, null);
            die();
        }
    }

    public function getPublicUserProfile($userInfo)
    {
        $publicUserProfile = new \Zaly\Proto\Core\PublicUserProfile();
        $avatar = isset($userInfo['avatar']) ? $userInfo['avatar'] : "";
        $publicUserProfile->setAvatar($avatar);
        $publicUserProfile->setUserId($userInfo['userId']);
        $publicUserProfile->setLoginname($userInfo['loginName']);
        $publicUserProfile->setNickname($userInfo['nickname']);
        $publicUserProfile->setNicknameInLatin($userInfo['nicknameInLatin']);

        if (isset($userInfo['availableType'])) {
            $publicUserProfile->setAvailableType($userInfo['availableType']);
        } else {
            $publicUserProfile->setAvailableType(\Zaly\Proto\Core\UserAvailableType::UserAvailableNormal);
        }
        return $publicUserProfile;
    }

    public function getGroupMemberUserProfile($user)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        $this->ctx->Wpf_Logger->error($tag, "user userMemberType  = " . $user['memberType']);

        $publicUserProfile = $this->getPublicUserProfile($user);

        $groupMemberUserProfile = new \Zaly\Proto\Site\ApiGroupMembersUserProfile();
        $groupMemberUserProfile->setProfile($publicUserProfile);

        $groupMemberUserProfile->setType((int)$user['memberType']);

        return $groupMemberUserProfile;
    }

    protected function finish_request()
    {
        if (!function_exists("fastcgi_finish_request")) {
            function fastcgi_finish_request()
            {
            }
        }
        fastcgi_finish_request();
    }

    protected function getAndSetClientLang()
    {
        $requestTransportData = $this->requestTransportData;
        $headers = $requestTransportData->getHeader();


        $headLang = isset($headers[TransportDataHeaderKey::HeaderUserClientLang]) ? $headers[TransportDataHeaderKey::HeaderUserClientLang] : "";

        $this->ctx->Wpf_Logger->info("client-language", "==" . $headLang);

        if (isset($headLang) && $headLang == Zaly\Proto\Core\UserClientLangType::UserClientLangZH) {
            $this->language = Zaly\Proto\Core\UserClientLangType::UserClientLangZH;
        }

    }

}