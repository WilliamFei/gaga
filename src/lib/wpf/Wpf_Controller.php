<?php

use \Zaly\Proto\Core\TransportDataHeaderKey;

abstract class Wpf_Controller {

	protected $ctx;
    public $zalyError;
	public function __construct(Wpf_Ctx $context) {
		$this->ctx = $context;
	}

	public function doIndex()
    {
	}


	public function response($data=array(), $errorCode=0, $errorInfo="") {
		$output = array(
				'errorCode' => $errorCode,
				'errorInfo' => $errorInfo,
				'data'      => $data
		);
		echo json_encode($output);
	}

    public function display($viewName, $params = []) {
        // 自己实现实现一下这个方法，加载view目录下的文件
        // 自己实现实现一下这个方法，加载view目录下的文件
        ob_start();
        $fileName = str_replace("_", "/", $viewName);
        $path = dirname(dirname(__DIR__)).'/views/'.$fileName.'.php';
        if ($params) {
            extract($params, EXTR_SKIP);
        }
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }

	final public function parseUrlParamByPattern($urlParamPattern) {
		$m = $this->ctx->Wpf_Router->parseUrlParamByPattern($urlParamPattern);
		$_REQUEST = array_merge($_REQUEST, $m);
	}

	public function getParam($key) {
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
	}

    public function getZalyErrorLang()
    {
        $requestTransportData = $this->requestTransportData;
        $headers = $requestTransportData->getHeader();
        if(!isset($headers[TransportDataHeaderKey::HeaderUserClientLang])
            || ($headers[TransportDataHeaderKey::HeaderUserClientLang] == \Zaly\Proto\Core\UserClientLangType::UserClientLangZH)) {
            $this->zalyError = $this->ctx->ZalyErrorZh;
        } else {
            $this->zalyError = $this->ctx->ZalyErrorEn;
        }
    }

    public function checkDBIsExist()
    {
        $sqliteInfo = ZalyConfig::getConfig("sqlite");
        $sqliteName = $sqliteInfo['sqliteDBName'];
        if(empty($sqliteName)) {
            return false;
        }
        $sqliteName = dirname(__FILE__).'/../../'.$sqliteName;
        if(file_exists($sqliteName)) {
            return true;
        }

        return false;
    }
}