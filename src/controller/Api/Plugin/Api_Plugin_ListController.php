<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 17/07/2018
 * Time: 11:23 AM
 */

class Api_Plugin_ListController extends \BaseController
{
    private $classNameForRequest = '\Zaly\Proto\Site\ApiPluginListRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiPluginListResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiPluginListRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;
        try {
            $pluginUsageType = (int)$request->getUsageType();

            if ($pluginUsageType === false) {
                $errorCode = $this->zalyError->errorPluginList;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }

            $permissionTypes = [
                Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll,
                Zaly\Proto\Core\PluginPermissionType::PluginPermissionGroupMaster,
            ];

            $siteManagers = $this->ctx->Site_Config->getSiteManagers();

            if (in_array($this->userId, $siteManagers)) {
                $permissionTypes[] = Zaly\Proto\Core\PluginPermissionType::PluginPermissionAdminOnly;
            }

            switch ($pluginUsageType) {
                case Zaly\Proto\Core\PluginUsageType::PluginUsageIndex:
                case Zaly\Proto\Core\PluginUsageType::PluginUsageU2Message:
                case Zaly\Proto\Core\PluginUsageType::PluginUsageTmpMessage:
                case Zaly\Proto\Core\PluginUsageType::PluginUsageGroupMessage:
                    break;
                case Zaly\Proto\Core\PluginUsageType::PluginUsageLogin:
                default:
                    throw new Exception("mini program usageType error");
            }

            $pluginList = $this->getPluginListFromDB($pluginUsageType, $permissionTypes);

            $response = $this->buildApiPluginListResponse($pluginList);

            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex);
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    /**
     * 从数据库获取
     * @param $usageType
     * @param $permissionTypes
     * @return array
     */
    private function getPluginListFromDB($usageType, $permissionTypes)
    {
        return $this->ctx->SitePluginTable->getPluginList($usageType, $permissionTypes);
    }

    /**
     * 获取plugin list
     * @param $sessionId
     * @param $pluginList
     * @param $pluginPublicKey
     * @return \Zaly\Proto\Site\ApiPluginListResponse
     */
    private function buildApiPluginListResponse($sessionId, $pluginList, $pluginPublicKey)
    {
        $response = new \Zaly\Proto\Site\ApiPluginListResponse();
        $list = [];
        foreach ($pluginList as $key => $plugin) {
            $pluginProfile = new \Zaly\Proto\Core\PluginProfile();

            $pluginProfile->setId($plugin['pluginId']);
            $pluginProfile->setName($plugin['name']);
            $pluginProfile->setLogo($plugin['logo']);
            if ($plugin['sort']) {
                $pluginProfile->setOrder($plugin['sort']);
            } else {
                $pluginProfile->setOrder(100);
            }
            $pluginProfile->setLandingPageUrl($plugin['landingPageUrl']);

            if ($plugin['landingPageWithProxy'] == 1) {//1:true 0:false
                $pluginProfile->setLandingPageWithProxy(true);
            }

            if ($plugin['loadingType']) {
                $pluginProfile->setLoadingType($plugin['loadingType']);
            } else {
                $pluginProfile->setLoadingType(\Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage);
            }

            $pluginAuthKey = $plugin['authKey'];

            if (empty($pluginAuthKey)) {
                $pluginAuthKey = $pluginPublicKey;
            }

            $encryptedSessionId = $this->ctx->ZalyAes->encrypt($sessionId, $pluginAuthKey);

            $pluginProfile->setUserSessionId($encryptedSessionId);

            $list[] = $pluginProfile;
        }
        $response->setList($list);
        return $response;
    }
}