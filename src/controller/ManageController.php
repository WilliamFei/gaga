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

abstract class ManageController extends \Wpf_Controller
{
    protected $userId;
    protected $userInfo;
    protected $sessionId;
    public $defaultErrorCode = "success";
    public $errorCode = "fail";
    private $sessionIdTimeOut = 3600 * 1000 * 10; //毫秒  10个小时的毫秒
    public $defaultFilePath = "files";

    protected $ctx;

    protected $language = Zaly\Proto\Core\UserClientLangType::UserClientLangEN;
    protected $requestData;

    public function __construct(Wpf_Ctx $context)
    {
        $this->ctx = new BaseCtx();
    }

    protected abstract function doRequest();

    /**
     * 处理方法， 根据bodyFormatType, 获取transData
     * @return string|void
     */
    public function doIndex()
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;

        try {
            parent::doIndex();

            // 接收的数据流
            $this->requestData = file_get_contents("php://input");



            $this->getAndSetClientLang();

            $this->doRequest();
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error msg =" . $ex->getMessage());
            $this->setLogout();
        }
    }

    public function getUserIdByCookie()
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        try {
            $cookie = isset($_COOKIE['zaly_site_user']) ? $_COOKIE['zaly_site_user'] : "";

            if (!$cookie) {
                throw new Exception("cookie is not found");
            }
            $cookieDecode = base64_decode($cookie);

            $this->userId = $this->ctx->ZalyAes->decrypt($cookieDecode, $this->ctx->ZalyAes->cookieKey);

            $this->userInfo = $this->ctx->SiteUserTable->getUserByUserId($this->userId);
            if (!$this->userInfo) {
                throw new Exception("user not exists");
            }

            $sessionInfo = $this->ctx->SiteSessionTable->getSessionInfoByUserId($this->userId);
            $this->ctx->Wpf_Logger->info($tag, json_encode($sessionInfo));
            if (!$sessionInfo) {
                throw new Exception("session is not ok");
            }
            $timeActive = $sessionInfo['timeActive'];

            $nowTime = $this->ctx->ZalyHelper->getMsectime();

            if (($nowTime - $timeActive) > $this->sessionIdTimeOut) {
                throw new Exception("session is not ok");
            }

            $this->sessionId = $sessionInfo['sessionId'];
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error msg =" . $ex->getMessage());
            $this->setLogout();
            exit();
        }
    }

    public function setLogout()
    {
        $tag = __CLASS__ . '_' . __FUNCTION__;
        setcookie("zaly_site_user", "", time() - 3600, "/", "", false, true);
        echo $this->display("login_login");
        exit();
    }

    public function setTransDataHeaders($key, $val)
    {
        $key = "_{$key}";
        $this->headers[$key] = $val;
    }

    public function setHeader()
    {
        $this->setTransDataHeaders(TransportDataHeaderKey::HeaderSessionid, $this->sessionId);
        $this->setTransDataHeaders(TransportDataHeaderKey::HeaderUserAgent, $_SERVER['HTTP_USER_AGENT']);
    }

    public function display($viewName, $params = [])
    {
        // 自己实现实现一下这个方法，加载view目录下的文件
        $params['session_id'] = $this->sessionId;
        $params['user_id'] = $this->userId;
//        $params['platform_login_url'] = ZalyConfig::getConfig("apiPlatformLogin");
//        $params['nickname'] = $this->userInfo['nickname'];
//        $params['avatar'] = $this->userInfo['avatar'];
        return parent::display($viewName, $params);
    }

    public function setCookieBase64($userId)
    {
        error_log("set cookie base 64 ==" . $userId);
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