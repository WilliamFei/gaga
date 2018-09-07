<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 05/09/2018
 * Time: 2:27 PM
 */

class MiniProgram_Square_IndexController extends MiniProgramController
{

    private $squarePluginId = 102;

    public function getMiniProgramId()
    {
        return $this->squarePluginId;
    }

    public function doRequest()
    {
        header('Access-Control-Allow-Origin: *');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            $fromUserId = $_POST['fromUserId'];
            $roomId = $_POST['roomId'];
            $roomType = $_POST['roomType'];

        } else {
            echo "user square";
            return;
        }

    }
}