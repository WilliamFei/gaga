<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 03/09/2018
 * Time: 1:41 PM
 */

 return array (
     'apiPageIndex' => '/index.php?action=page.index',
     'apiPageLogin' => '/index.php?action=page.login',
     'apiPageLogout' => '/index.php?action=page.logout',
     'apiPageJump'   => "/index.php?action=page.jump",
     'loginPluginId' => '105',
     'apiPageWidget' => '/index.php?action=page.widget',
     'apiPageSiteInit' => "/index.php?action=installDB",
     'apiSiteLogin' => '/index.php?action=api.site.login&body_format=pb',
     'session_verify_100' => 'http://open.akaxin.com:5208/index.php?action=api.session.verify&body_format=pb',
     'session_verify_105' => 'http://127.0.0.1:5207/index.php?action=api.session.verify&body_format=pb',
     'mail' =>
         array (
             'host' => 'smtp.126.com',
             'SMTPAuth' => true,
             'emailAddress' => 'xxxx@126.com',
             'password' => '',
             'SMTPSecure' => '',
             'port' => 25,
         ),
     'sqlite' =>
         array (
             'sqliteDBPath' => '.',
             'sqliteDBName' => '',
         ),
     "dbVersion" => "2",
     'logPath' => '.',
     "debugMode" => false,
     'msectime' => 1535945699185.0,
 );
