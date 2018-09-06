<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 17/08/2018
 * Time: 3:42 PM
 */

class Page_LoginController extends HttpBaseController
{
    public  $headers;

    public function index()
    {
        echo $this->display("login_login");
        return;
    }
}