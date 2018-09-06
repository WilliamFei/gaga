<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 19/07/2018
 * Time: 10:54 AM
 */

class ZalyConfig
{
    public static $config;
    private static $verifySessionKey="session_verify_";
    public static function getConfigFile()
    {
        $fileName = dirname(__FILE__) ."/../../config.php";
        if(!file_exists($fileName)) {
            $fileName = dirname(__FILE__) ."/../../config.sample.php";
        }

        self::$config = require($fileName);
    }

    public static function  getConfig($key = "")
    {
        self::getConfigFile();
        if(isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return self::$config;
    }

    public static function getSessionVerifyUrl($pluginId)
    {
        self::getConfigFile();
        $key = self::$verifySessionKey.$pluginId;
        return self::$config[$key];
    }

    public static function getApiPageIndexUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageIndex'];
    }

    public static function getApiPageJumpUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageJump'];
    }

    public static function getApiPageWidget()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageWidget'];
    }

    public static function getDomain()
    {
        self::getConfigFile();

        $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME']."://" : "";
        $domain = isset($_SERVER['HTTP_HOST']) ?$_SERVER['HTTP_HOST'] : "" ;

        return $scheme.$domain;
    }

    public static function getApiPageMsgUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageMsg'];
    }

    public static function getApiSiteLoginUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiSiteLogin'];
    }

    public static function getApiPageLoginUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageLogin'];
    }

    public static function getApiPageLogoutUrl()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageLogout'];
    }

    public static function getApiPageSiteInit()
    {
        $domain = self::getDomain();
        return $domain.self::$config['apiPageSiteInit'];
    }
}