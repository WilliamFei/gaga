<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 2:55 PM
 */

class DB_Base
{
    public $db;
    public $dbPath = ".";
    public $dbName;
    public $wpf_Logger;

    public function __construct()
    {
        $this->wpf_Logger = new Wpf_Logger();
        $this->initSite();
    }

    private function initSite()
    {
        $configs = ZalyConfig::getConfig("sqlite");
        $this->dbName = $configs['sqliteDBName'];
        $dbInfo = $this->dbPath . "/" . $this->dbName;
        $this->db = new \PDO("sqlite:{$dbInfo}");
    }

    public function checkTableExists($tableName)
    {
        $tag = __CLASS__."-".__FUNCTION__;
        try{
            $sql = 'select count(*)  from sqlite_master where type="table" and name = "'.$tableName.'";';
            return $this->db->exec($sql);
        }catch (Exception $ex) {
            $this->wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());
        }
    }


}