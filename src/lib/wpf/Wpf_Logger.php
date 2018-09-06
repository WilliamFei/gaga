<?php

/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 13/07/2018
 * Time: 11:48 AM
 */
class Wpf_Logger
{
    private $_level = [
        "info",
        "warn",
        "error",
        "sql"
    ];

    private $errorLevel = "error";
    private $warnLevel  = "warn";
    private $infoLevel  = "info";
    private $sqlLevel   = "sql";

    private $fileName = 'duckchat-site';
    private $handler = '';
    private $logType = "";

    private $debugInfoHeader = "duckchat-debugInfo";

    private $debugMode;

    public function __construct()
    {
        $this->fileName = $this->fileName . "-" . date("Ymd") . ".log";

        $this->filePath = ZalyConfig::getConfig("logPath");
        if($this->filePath == ".") {
            $this->filePath = dirname(__DIR__)."/../logs/";
        }
        $this->filePath = $this->filePath . "/" . $this->fileName;
        $this->handler = fopen($this->filePath, "a+");

        $this->debugMode = ZalyConfig::getConfig("debugMode");
    }

    /**
     * info log
     * @param $tag
     * @param $infoMsg
     */
    public function info($tag, $infoMsg)
    {
        $this->logType = $this->infoLevel;
        $this->writeLog($tag, $infoMsg);
    }

    /**
     * warn log
     * @param $tag
     * @param $infoMsg
     */
    public function warn($tag, $infoMsg)
    {
        $this->logType = $this->warnLevel;
        $this->writeLog($tag, $infoMsg);
    }

    /**
     * error log
     * @param $tag
     * @param $infoMsg
     */
    public function error($tag, $infoMsg)
    {
        $this->logType = $this->errorLevel;
        $this->writeLog($tag, $infoMsg);
    }

    /**
     * write log
     * @param $tag
     * @param $msg
     */
    private function writeLog($tag, $msg)
    {

        if (!in_array($this->logType, $this->_level)) {
            return;
        }

        if (is_array($msg)) {
            $msg = json_encode($msg);
        }

        $content = "[$this->logType] " . date("Y-m-d H:i:s") . " $tag $msg \n";

        if($this->debugMode == true) {
            header($this->debugInfoHeader.":".$content);
            fwrite($this->handler, $content);
        }

        if($this->debugMode == false && $this->logType == $this->errorLevel) {
            fwrite($this->handler, $content);
        }

    }

    public function writeSqlLog($tag, $sql, $params = [], $startTime = 0)
    {
        if (is_array($params)) {
            $params = json_encode($params);
        }
        $this->logType = $this->sqlLevel;
        $expendTime = microtime(true) - $startTime;

        $content = "[$this->logType] " . date("Y-m-d H:i:s") . " $tag  sql=$sql  params=$params  expend_time=$expendTime\n";

        if($this->debugMode == true) {
            header($this->debugInfoHeader.":".$content);
            fwrite($this->handler, $content);
            return;
        }
    }

    public function dbLog($tag, $sql, $params = [], $startTime = 0, $result)
    {
        if (is_array($params)) {
            $params = json_encode($params);
        }

        if (is_array($result)) {
            $result = json_encode($result);
        }
        $this->logType = $this->sqlLevel;
        $expendTime = microtime(true) - $startTime;
        $content = "[$this->logType] "
            . date("Y-m-d H:i:s")
            . " $tag  sql=$sql  params=$params  expend_time=$expendTime "
            . "result=$result \n";
        if($this->debugMode == true) {
            header($this->debugInfoHeader.":".$content);
            fwrite($this->handler, $content);
            return;
        }
    }
}
