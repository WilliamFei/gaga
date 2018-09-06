<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_UserController extends ManageController
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

        $params['userList'] = $this->getUserListByOffset($offset, $length);

        echo $this->display("manage_user_indexList", $params);
        return;
    }

    private function getUserListByOffset($offset, $length)
    {
        return $this->ctx->SiteUserTable->getSiteUserListByOffset($offset, $length);
    }

}