<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 2:39 PM
 */

class UpdateVersionController extends HttpBaseController
{
    private $configName = "config.php";
    private $sampleConfigName = "config.sample.php";

    public function index()
    {
        $ownerInfo = $this->getSiteConfigFromDB(SiteConfig::SITE_OWNER);
        $ownerId = isset($ownerInfo['owner']) ? $ownerInfo['owner'] : "";

        if($ownerId != $this->userId) {
            $indexUrl = ZalyConfig::getApiPageIndexUrl();
            header("Location:".$indexUrl);
            exit();
        }

        $configFileName = dirname(__FILE__) . "/../". $this->configName;
        $sampleFileName = dirname(__FILE__) . "/../". $this->sampleConfigName;
        if(file_exists($configFileName)) {
            $configOlder = require($configFileName);
            $configSampleNew =  require($sampleFileName);

            $configs = array_merge($configSampleNew, $configOlder);
            $contents = var_export($configs, true);
            file_put_contents($configFileName, "<?php\n return {$contents};\n ");

            if (function_exists("opcache_reset")) {
                opcache_reset();
            }
            $configOlder['dbVersion'] = isset($configOlder['dbVersion'] ) ? $configOlder['dbVersion']  : 0;
            if($configOlder['dbVersion'] < $configSampleNew['dbVersion']) {
                $className = "DB_Version_V".$configSampleNew['dbVersion'];
                require (dirname(__DIR__)."/model/DB/".$className.".php");
                $className::getInstance()->upgradeDB();
            }
            $indexUrl = ZalyConfig::getApiPageIndexUrl();
            header("Location:".$indexUrl);
            exit();
        } else {
            $initUrl = ZalyConfig::getApiPageSiteInit();
            header("Location:".$initUrl);
            exit();
        }
    }
}