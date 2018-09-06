<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 28/08/2018
 * Time: 6:40 PM
 */

class Manage_MiniProgram_ProfileController extends ManageController
{

    protected function doRequest()
    {
        $params = [];
        $params['lang'] = $this->language;


        $pluginId = $_GET['pluginId'];


        $this->ctx->Wpf_Logger->info("===============", json_encode($params));

        echo $this->display("manage_miniProgram_profile", $params);
        return;
    }


    private function getPluginProfile($pluginId)
    {

    }
}