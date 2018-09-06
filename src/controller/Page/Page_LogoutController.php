<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 03/08/2018
 * Time: 10:20 AM
 */

class Page_LogoutController extends HttpBaseController
{

    public function index()
    {
        setcookie ("zaly_site_user", "", time()-3600, "/", "", false, true);
        $apiPageIndex = ZalyConfig::getApiPageIndexUrl();
        header("Location:".$apiPageIndex);
        exit();
    }
}