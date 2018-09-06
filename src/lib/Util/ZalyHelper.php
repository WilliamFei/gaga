<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 17/07/2018
 * Time: 9:57 AM
 */

class ZalyHelper
{
    /*
     * php 毫秒
     */
    public static function getMsectime()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }

    public function getCurrentTimeSeconds()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)));
        return $msectime;
    }

    public static function generateStrId()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function generateStrKey($length = 16, $strParams = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            $length = 16;
        }

        $str = '';
        for ($i = $length; $i > 0; $i--) {
            $str .= $strParams[mt_rand(0, strlen($strParams) - 1)];
        }

        return $str;
    }


    public static function generateNumberKey($length = 16, $strParams = '0123456789')
    {
        if (!is_int($length) || $length < 0) {
            $length = 16;
        }

        $str = '';
        for ($i = $length; $i > 0; $i--) {
            $str .= $strParams[mt_rand(0, strlen($strParams) - 1)];
        }

        return $str;
    }


    public function judgeOrigin()
    {
        //获取USER AGENT
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        //分析数据
        $isWeb = (strpos($agent, 'windows nt')) ? true : false;
        $isIphone = (strpos($agent, 'iphone')) ? true : false;
        $isAndroid = (strpos($agent, 'android')) ? true : false;
        //输出数据
        if ($isWeb) {
            return 1;
        }

        if ($isIphone || $isAndroid) {
            return 0;
        }

    }


    public static function quickSortMsg($arr)
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        }
        $key = $arr[0];
        $arrLeft = array();
        $arrRight = array();
        for ($i = 1; $i < $len; $i++) {
            if ($arr[$i]["msgTime"] <= $key["msgTime"]) {
                $arrLeft[] = $arr[$i];
            } else {
                $arrRight[] = $arr[$i];
            }
        }
        $arrLeft = self::quickSortMsg($arrLeft);
        $arrRight = self::quickSortMsg($arrRight);
        return array_merge($arrRight, array($key), $arrLeft);
    }

    public static function hideMobile($phone)
    {
        $isMob = "/^1[0-9]{1}\d{9}$/";

        if (preg_match($isMob, $phone)) {
            $phone = substr_replace($phone, '****', 3, 4);
        }
        return $phone;
    }

    public static function checkOpensslEncryptExists()
    {
        if (!function_exists("openssl_encrypt")) {
            return false;
        }
        return true;
    }

    public static function isEmail($email)
    {
        return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email);
    }

    public static function isPhoneNumber($phoneNumber)
    {
        return preg_match("/^1[3456789]{1}\d{9}$/", $phoneNumber);
    }
}