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
        $pluginId = $_GET['pluginId'];

        $miniProgramProfile = $this->getPluginProfile($pluginId);
        $miniProgramProfile['lang'] = $this->language;

        $this->ctx->Wpf_Logger->info("===============", json_encode($miniProgramProfile));

        echo $this->display("manage_miniProgram_profile", $miniProgramProfile);
        return;
    }


    private function getPluginProfile($pluginId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            return $this->ctx->SitePluginTable->getPluginById($pluginId);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return [];
    }

}