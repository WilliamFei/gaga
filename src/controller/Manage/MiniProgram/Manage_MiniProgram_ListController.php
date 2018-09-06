<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 28/08/2018
 * Time: 6:40 PM
 */

class Manage_MiniProgram_ListController extends ManageController
{
    protected function doRequest()
    {
        $params = [];
        $params['lang'] = $this->language;

        $type = $_GET['type'];


        if ($type == "page") {
            $miniProgramList = $this->getMiniProgramList(0, 100);

            $params["miniProgramList"] = $miniProgramList;

            $this->ctx->Wpf_Logger->info("===============", json_encode($params));

            echo $this->display("manage_miniProgram_list", $params);
        } else {
            //for list data

            echo "no data";
        }

        return;
    }


    private function getMiniProgramList($offset, $count)
    {
        $list = $this->ctx->SitePluginTable->getAllPluginList();

        return $list;
    }

}