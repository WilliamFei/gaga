<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 11:05 AM
 */

class Manage_IndexController extends ManageController
{

    public function doRequest()
    {
        //jump to backStage management
        echo $this->display("manage_index");
        return;
    }

}