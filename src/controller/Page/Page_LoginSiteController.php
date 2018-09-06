<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 23/08/2018
 * Time: 11:18 AM
 */

class Page_LoginSiteController extends  HttpBaseController
{

    public function index()
    {
        echo $this->display("login_loginSite");
        return;
    }
}