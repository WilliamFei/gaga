<?php
/**
 * WEB应用程序初始化
 * 
 * 应用程序必须自己预先在model文件夹定义一个BaseCtx的类
 */

define("WPF_START_TIME", microtime(true));
define("WPF_LIB_DIR", dirname(__FILE__) . '/../');

//设置配置项
$_ENV['WPF_CONTROLLER_NAME_SUFFIX'] = "Controller";	//Controller类名的后缀，默认为Controller
//$_ENV['WPF_URL_PATH_SUFFIX']，URL目录部分的前缀，前缀不参与路由

//防止服务器没有设置默认时间而报错
date_default_timezone_set('Asia/Shanghai');

//手动引入肯定需要的文件
require_once(WPF_LIB_DIR . '/wpf/Wpf_Loader.php');
require_once(WPF_LIB_DIR . '/wpf/Wpf_Web.php');
require_once(WPF_LIB_DIR . '/wpf/Wpf_Controller.php');
require_once(WPF_LIB_DIR . '/wpf/Wpf_Router.php');
require_once(WPF_LIB_DIR . '/wpf/Wpf_Ctx.php');
require_once(WPF_LIB_DIR . '/wpf/Wpf_Logger.php');


//激活自动加载
$autoloader = new Wpf_Autoloader();
$autoloader->addDir(WPF_LIB_DIR . '/../model/');
$autoloader->addDir(WPF_LIB_DIR);
$autoloader->addDir(WPF_LIB_DIR."/proto/");
$autoloader->addDir(WPF_LIB_DIR."/Util/");
$autoloader->addDir(WPF_LIB_DIR."/Overtrue/");
$autoloader->addDir(WPF_LIB_DIR."/PHPMailer/");
$autoloader->addDir(WPF_LIB_DIR . '/../config/');
$autoloader->addDir(WPF_LIB_DIR . '/../controller/');
spl_autoload_register(array($autoloader, 'load'));

//生成WEB程序管理器，开始执行逻辑
$web = new Wpf_Web();
$web->run();

//其他
define("WPF_END_TIME", microtime(true));
//printf("\n<br />request time:%fms\n", (WPF_END_TIME-WPF_START_TIME)*1000);
