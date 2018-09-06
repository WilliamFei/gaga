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

        $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME']."://" : "http://";
        $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "" ;

        return $scheme.$domain;
    }
}