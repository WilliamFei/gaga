<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_GroupController extends ManageController
{

    public function doRequest()
    {
        $params = ["lang" => $this->language];

        //get user list by page
        $offset = $_POST['offset'];
        $length = $_POST['length'];

        if (!$offset) {
            $offset = 0;
        }

        if (!$length) {
            $length = 50;
        }

        $params['groupList'] = $this->getGroupListByOffset($offset, $length);

        echo $this->display("manage_group_indexList", $params);

        return;
    }

    private function getGroupListByOffset($offset, $length)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            return $this->ctx->SiteGroupTable->getSiteGroupListByOffset($offset, $length);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->info($tag, $e);
        }
        return [];
    }
}