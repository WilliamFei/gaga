<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:58 AM
 */

class Manage_ConfigController extends ManageController
{
    /**
     * 站点管理
     */
    public function doRequest()
    {

        $config = $this->ctx->SiteConfigTable->selectSiteConfig();
        $config[SiteConfig::SITE_ID_PRIK_PEM] = "";
        $config['lang'] = $this->language;

        echo $this->display("manage_config_index", $config);
        return;
    }

}