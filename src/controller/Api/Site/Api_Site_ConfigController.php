<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 13/07/2018
 * Time: 11:20 AM
 */

use Zaly\Proto\Core\TransportDataHeaderKey;
use Zaly\Proto\Site\ApiSiteConfigResponse;
use Zaly\Proto\Core\PublicSiteConfig;

class Api_Site_ConfigController extends \BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiSiteConfigRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiSiteConfigResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiSiteConfigRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        ///处理request，
        $tag = __CLASS__ . '-' . __FUNCTION__;

        try {

            $requestHeader = $transportData->getHeader();
            $hostUrl = $requestHeader[TransportDataHeaderKey::HeaderHostUrl];

            $url = parse_url($hostUrl);

            if (empty($url)) {
                throw new Exception("api.site.config with no requestUrl in header");
            }
            $host = isset($url['host']) ? $url['host'] : "";
            $port = isset($url['port']) ? $url['port'] : "";
            if (empty($host)) {
                throw new Exception("api.site.config with error url");
            }
            $siteName = $host;

            $this->ctx->Wpf_Logger->info("api.site.config", "siteName =" . $siteName);
            $this->ctx->Wpf_Logger->info("api.site.config", "siteHost =" . $host);
            $this->ctx->Wpf_Logger->info("api.site.config", "sitePort =" . $port);

            if (empty($host)) {
                throw new Exception("request config with no host");
            }

            $randomValue = $request->getRandom();

            $sessionId = $this->getSessionId($transportData);

            $isValid = $this->checkSessionValid($sessionId);

            $configData = $this->getSiteConfigFromDB();

            $randomBase64 = $this->buildRandomBase64($randomValue, $configData[SiteConfig::SITE_ID_PRIK_PEM]);

            $loginPluginProfile = $this->getPluginProfileFromDB($configData[SiteConfig::SITE_LOGIN_PLUGIN_ID]);

            $response = $this->buildSiteConfigResponse($host, $port, $configData, $isValid, $randomBase64, $loginPluginProfile);

            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error=" . $ex);
            $this->setRpcError("error.alert", $ex->getMessage());
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }

    }


    /**
     * @param $sessionId
     * @return bool
     */
    private function checkSessionValid($sessionId)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        $this->ctx->Wpf_Logger->error($tag, "check session id ");
        $requestTransportData = $this->requestTransportData;
        $headers = $requestTransportData->getHeader();

        if (!isset($headers[TransportDataHeaderKey::HeaderSessionid])) {
            return false;
        }

        $this->sessionId = $headers[TransportDataHeaderKey::HeaderSessionid];

        $sessionInfo = $this->ctx->SiteSessionTable->getSessionInfoBySessionId($this->sessionId);
        if (!$sessionInfo) {
            return false;
        }
        $timeActive = $sessionInfo['timeActive'];
        $nowTime = $this->ctx->ZalyHelper->getMsectime();

        if (($nowTime - $timeActive) > $this->sessionIdTimeOut) {
            $this->ctx->Wpf_Logger->error($tag, "session  time out  , session id = " . $sessionId);
            return false;
        }

        $this->userId = $sessionInfo['userId'];
        $this->deviceId = $sessionInfo['deviceId'];
        $this->userInfo = $this->ctx->SiteUserTable->getUserByUserId($this->userId);
        if (!$this->userInfo) {
            return false;
        }

        return true;
    }

    /**
     * 查库操作
     */
    private function getSiteConfigFromDB()
    {
        try {
            $results = $this->ctx->SiteConfigTable->selectSiteConfig();
            return $results;
        } catch (Exception $e) {
            $tag = __CLASS__ . "-" . __FUNCTION__;
            $this->ctx->Wpf_Logger->error($tag, "bodayFormatType ==  $this->bodyFormatType errorMsg = " . $e->getMessage());
            return [];
        }
    }

    private function getPluginProfileFromDB($loginPluginId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        $pluginProfile = $this->ctx->SitePluginTable->getPluginById($loginPluginId);
        $this->ctx->Wpf_Logger->info($tag, "pluginProfile=" . json_encode($pluginProfile));
        return $pluginProfile;
    }


    private function buildRandomBase64($random, $siteIdPrikBase64)
    {
//        $this->ctx->Wpf_Logger->info("config.random.sign", 'random=' . $random);
        try {
            $signatureRandom = $this->ctx->ZalyRsa->sign($random, $siteIdPrikBase64);
            $base64Value = base64_encode($signatureRandom);
//            $this->ctx->Wpf_Logger->info("config.random.base64", 'randomBase64Value=' . $base64Value);
            return $base64Value;
        } catch (Exception $e) {
            # TODO 正式代码，这里 throw exception
            $this->ctx->Wpf_Logger->info("api.site.config", $e);
        }
        return '';
    }

    /**
     * 生成 transData 数据
     * @param $host
     * @param $port
     * @param $configData
     * @param bool $isValid
     * @param $randomBase64
     * @param $pluginProfile
     * @return ApiSiteConfigResponse
     * @throws Exception
     */
    private function buildSiteConfigResponse($host, $port, $configData, $isValid, $randomBase64, $pluginProfile)
    {
        ////ApiSiteConfigResponse 对象
        $response = new ApiSiteConfigResponse();

        try {
            $config = new PublicSiteConfig();
            $config->setName($configData[SiteConfig::SITE_NAME]);
            $config->setLogo($configData[SiteConfig::SITE_LOGO]);//        //notice
            if (isset($configData[SiteConfig::SITE_OWNER])) {
                $config->setMasters($configData[SiteConfig::SITE_OWNER]);
            }

            $zalyPort = $configData[SiteConfig::SITE_ZALY_PORT];
            $wsPort = $configData[SiteConfig::SITE_WS_PORT];

            $this->ctx->Wpf_Logger->info("api.site.config", "zalyPort=" . $zalyPort . " wsPort=" . $wsPort);


            $addressForAPi = "";
            $addressForIM = "";
            if ($zalyPort && $zalyPort > 0 && $zalyPort < 65535) {
                //support zaly protocol
                $addressForAPi = "zaly://" . "$host" . ":" . $zalyPort;
                $addressForIM = "zaly://" . "$host" . ":" . $zalyPort;
            } else if ($wsPort && $wsPort > 0 && $wsPort < 65535) {
                //support ws protocol
                $addressForAPi = "http://" . "$host" . ":" . $port;
                $addressForIM = "ws://" . "$host" . ":" . "$wsPort";
            } else {
                //support http protocol
                $addressForAPi = "http://" . "$host" . ":" . $port;
                $addressForIM = "http://" . "$host" . ":" . $port;
            }

            $this->ctx->Wpf_Logger->info("api.site.config", "addressForAPi=" . $addressForAPi);
            $this->ctx->Wpf_Logger->info("api.site.config", "addressForIM=" . $addressForIM);

            $config->setServerAddressForApi($addressForAPi);
            $config->setServerAddressForIM($addressForIM);

            $config->setLoginPluginId($configData[SiteConfig::SITE_LOGIN_PLUGIN_ID]);
            $config->setEnableCreateGroup($configData[SiteConfig::SITE_ENABLE_CREATE_GROUP]);
            $config->setEnableAddFriend($configData[SiteConfig::SITE_ENABLE_ADD_FRIEND]);
            $config->setEnableTmpChat($configData[SiteConfig::SITE_ENABLE_TMP_CHAT]);
            $config->setEnableInvitationCode($configData[SiteConfig::SITE_ENABLE_INVITATION_CODE]);
            $config->setEnableRealName($configData[SiteConfig::SITE_ENABLE_REAL_NAME]);
            $config->setEnableWidgetWeb($configData[SiteConfig::SITE_ENABLE_WEB_WIDGET]);
            $config->setSiteIdPubkBase64($configData[SiteConfig::SITE_ID_PUBK_PEM]);

            $response->setConfig($config);

//            $this->ctx->Wpf_Logger->info("api.site.config", 'responseJson=' . $response->serializeToString());
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error("api.site.config", $e);
            throw new Exception('get site config profile error');
        }

        //login profile
        try {
            $loginPluginProfile = new Zaly\Proto\Core\PluginProfile();
            $loginPluginProfile->setId($pluginProfile['pluginId']);
            $loginPluginProfile->setLogo($pluginProfile['logo']);
            $loginPluginProfile->setName($pluginProfile['name']);
            $loginPluginProfile->setLandingPageUrl($pluginProfile['landingPageUrl']);
            $loginPluginProfile->setLandingPageWithProxy($pluginProfile['landingPageWithProxy']);
            $loginPluginProfile->setLoadingType($pluginProfile['loadingType']);
            $loginPluginProfile->setOrder($pluginProfile['sort']);
            $loginPluginProfile->setUsageTypes([$pluginProfile['usageType']]);
            $loginPluginProfile->setPermissionType($pluginProfile['permissionType']);
            $response->setLoginPluginProfile($loginPluginProfile);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->info("api.site.config.plugin", $e);
            throw new Exception('get config login plugin profile error');
        }

        $response->setRandomSignBase64($randomBase64);
        $response->setIsSessionValid($isValid);

        return $response;
    }

//    private function doSiteConfigInit($siteName, $host, $port)
//    {
//        //初始化 config and plugin
//        $this->ctx->initSite($siteName, $host, $port, 'http', 'http');
//    }

    ////TODO 临时检测数据库是否可写， 以后移出到创建站点的引导页
    private function checkDBCanWrite()
    {
        $dbFilePath = dirname(__DIR__) . "/openzalySiteDB.sqlite3";
        $flag = is_writable($dbFilePath);
        if (!$flag) {
            $errorCode = $this->zalyError->errorDBWritable;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($this->action, null);
            return;
        }
    }
}

