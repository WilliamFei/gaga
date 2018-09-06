<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 4:44 PM
 */

class Site_Config
{

    private $ctx;

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
    }


    /**
     * @param $configKey
     * @return null
     */
    public function getConfigValue($configKey)
    {
        $configValues = $this->ctx->SiteConfigTable->selectSiteConfig($configKey);
        if ($configValues) {
            return $configValues[$configKey];
        }
        return null;
    }

    public function getAllConfig()
    {
        return $this->ctx->SiteConfigTable->selectSiteConfig();
    }

    /**
     * get administrator,site has just one administrator
     * @return null
     */
    public function getSiteOwner()
    {
        $adminValue = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_OWNER);

        if (isset($adminValue)) {
            return $adminValue[SiteConfig::SITE_OWNER];
        }

        return null;
    }

    /**
     * get managers ,site has many managers
     *
     * @return array
     */
    public function getSiteManagers()
    {
        $managers = [];

        $admin = $this->getSiteOwner();

        if (isset($admin)) {
            $managers[] = $admin;
        }

        $managersValue = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_MANAGERS);
        if ($managersValue) {
            $managersArray = explode(",", $managersValue);

            if (!empty($managersArray)) {
                $managers = array_merge($managers, $managersArray);
            }

        }

        return $managers;
    }

}