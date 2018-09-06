<?php


/**
 *
 * Help Ide Code AutoComplement
 *
 * @property File_Manager File_Manager
 * @property Site_Login Site_Login
 * @property SiteConfig SiteConfig
 *
 * @property Site_Config Site_Config
 *
 * @property SiteConfigTable SiteConfigTable
 * @property SiteSessionTable SiteSessionTable
 * @property SiteUserTable SiteUserTable
 * @property PassportPasswordTable PassportPasswordTable
 * @property PassportPasswordTokenTable PassportPasswordTokenTable
 * @property  PassportPasswordPreSessionTable PassportPasswordPreSessionTable
 * @property SiteUserFriendTable SiteUserFriendTable
 * @property SiteFriendApplyTable SiteFriendApplyTable
 * @property SiteU2MessageTable SiteU2MessageTable
 * @property SiteGroupTable SiteGroupTable
 * @property SiteGroupUserTable SiteGroupUserTable
 * @property SiteGroupMessageTable SiteGroupMessageTable
 * @property SiteUicTable SiteUicTable
 * @property SitePluginTable SitePluginTable
 *
 * @property Message_Client Message_Client
 * @property Message_News Message_News
 * @property Push_Client Push_Client
 * @property Gateway_Client Gateway_Client
 * @property Wpf_Logger Wpf_Logger
 * @property ZalyCurl ZalyCurl
 * @property ZalyRsa ZalyRsa
 * @property ZalyAes ZalyAes
 * @property ZalyHelper ZalyHelper
 *
 * @property Pinyin Pinyin
 *
 */
class BaseCtx extends Wpf_Ctx
{
    public $db;
    private $_dbName = "openzalySiteDB.sqlite3";
    private $_dbPath = ".";
    private $_dbSqlFile = "./database-sql/site.sql";
    public $dbVersion = 1;
    private $dbName = "openzalySiteDB";
    private $dbUser = "root";
    private $dbPwd = "root";
    private $dbHost = "127.0.0.1";
    private $dbType = "sqlite";
    private $suffix = ".sqlite3";

    public function __construct()
    {
        $this->checkDBExists();
    }

    private function checkDBExists()
    {
        $sqliteConfig = ZalyConfig::getConfig("sqlite");
        $this->_dbName = $sqliteConfig['sqliteDBName'];
        if(!empty($this->_dbName)   && file_exists(dirname(__FILE__)."/../".$this->_dbName)) {
            switch ($this->dbType) {
                case "sqlite":
                    $dbInfo = $this->_dbPath . "/" . $this->_dbName;
                    $this->db = new \PDO("sqlite:{$dbInfo}");
                    break;
                case "mysql":
                    $dsn = "mysql:dbname=$this->dbName;host=$this->dbHost";
                    $this->db = new \PDO($dsn, $this->dbUser, $this->dbPwd);
                    break;
            }
        }
    }

}
