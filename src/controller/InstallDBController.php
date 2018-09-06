<?php

/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 25/08/2018
 * Time: 8:06 PM
 */
class InstallDBController
{
    private $_dbPath = ".";
    private $loginPluginIds = [100, 105];
    private $configName = "config.php";
    private $sampleConfigName = "config.sample.php";
    private $_dbName;
    private $db;

    /**
     * @var ZalyHelper
     */
    private $helper;

    public function doIndex()
    {
        $this->helper = new ZalyHelper();

        $configFileName = dirname(__FILE__) . "/../". $this->configName;
        $sampleFileName = dirname(__FILE__) . "/../". $this->sampleConfigName;
        if(file_exists($configFileName)) {
            $config = require($configFileName);
            $sqliteName = $config['sqlite']['sqliteDBName'];
        } else {
            $config = require($sampleFileName);
            $sqliteName = "";
        }

        if (!empty($sqliteName)) {
            $sqliteName = dirname(__FILE__) . '/../' . $sqliteName;
            $isInstalled = file_exists($sqliteName);
            if ($isInstalled) {
                $apiPageIndex = ZalyConfig::getApiPageIndexUrl();
                header("Location:" . $apiPageIndex);
                exit();
            }
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            try {
                $serverHost = $_SERVER['HTTP_HOST'];
                $port = $_SERVER['SERVER_PORT'];
                $hosts = explode(":", $serverHost);
                $host = array_shift($hosts);
                $scheme = $_SERVER['REQUEST_SCHEME'];
                $sessionVerifyUrl = $scheme . "://" . $serverHost . '/index.php?action=api.session.verify&body_format=pb';

                $loginPluginId = $_POST['pluginId'];
                $dbNameKey = ZalyHelper::generateStrKey(8);
                $sqliteName = "db." . md5($dbNameKey) . ".sqlite3";
                $config['sqlite']['sqliteDBName'] = $sqliteName;
                $config['loginPluginId'] = in_array($loginPluginId, $this->loginPluginIds) ? $loginPluginId : 100;
                $config['session_verify_105'] = $sessionVerifyUrl;
                $config['msectime'] = ZalyHelper::getMsectime();

                $contents = var_export($config, true);
                file_put_contents($configFileName, "<?php\n return {$contents};\n ");
                if (function_exists("opcache_reset")) {
                    opcache_reset();
                }

                $siteName = $host;
                $this->initSite($sqliteName, $siteName, $host, $port);
                echo "success";
            } catch (Exception $ex) {
                echo "fail";
                return;
            }
        } elseif ($method == "GET") {

            $permissionDirectory = is_writable(dirname(dirname(__FILE__)));
            $configFile = dirname(dirname(__FILE__)) . "/config.php";
            $attachDir = dirname(dirname(__FILE__)) . "/attachment";
            if (file_exists($configFile) && !is_writable($configFile)) {
                $permissionDirectory = false;
            }

            if (file_exists($attachDir) && !is_writable($attachDir)) {
                $permissionDirectory = false;
            }

            $params = [
                "isPhpVersionValid" => version_compare(PHP_VERSION, "7.0.0") >= 1,
                "isLoadOpenssl" => extension_loaded("openssl") && false != ZalyRsa::newRsaKeyPair(2048),
                "isLoadPDOSqlite" => extension_loaded("pdo_sqlite"),
                "isLoadCurl" => extension_loaded("curl"),
                "isWritePermission" => $permissionDirectory,
            ];
            echo $this->display("init_installSite", $params);
            return;
        }
    }

    private function display($viewName, $params = [])
    {
        // 自己实现实现一下这个方法，加载view目录下的文件
        // 自己实现实现一下这个方法，加载view目录下的文件
        ob_start();
        $fileName = str_replace("_", "/", $viewName);
        $path = dirname(__DIR__) . '/views/' . $fileName . '.php';
        if ($params) {
            extract($params, EXTR_SKIP);
        }
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }

    private function initSite($sqliteName, $siteName, $siteHost, $Port)
    {
        $this->_dbName = $sqliteName;
        $this->checkDBExists();
        $this->_checkDBAndTable($siteName, $siteHost, $Port);
    }

    private function checkDBExists()
    {
        $dbInfo = $this->_dbPath . "/" . $this->_dbName;
        $this->db = new \PDO("sqlite:{$dbInfo}");
    }

    private function _checkDBAndTable($siteName, $siteHost, $Port)
    {
        $this->_checkDBTables();
        $this->_checkConfigDefaultValue($siteName, $siteHost, $Port);
    }


    private function _checkDBTables()
    {
        ////TODO 检测数据表是否存在
//        $sql = 'sqlite3 $this->_dbName  ".read {$this->_dbSqlFile}"';
//        $this->db->exec($sql);
        $this->_checkSiteConfigTable();
        $this->_checkSiteGroupTable();
        $this->_checkSiteGroupUserTable();
        $this->_checkSitePluginTable();
        $this->_checkSiteSessionTable();
        $this->_checkSiteUserTable();

        $this->_checkSiteU2MessageTable();// check table + index
        $this->_checkSiteU2MessagePointerTable();// check table + index

        $this->_checkSiteGroupMessageTable();// check table + index
        $this->_checkSiteGroupMessagePointerTable();// check table + index
        $this->_checkSiteUicTable();

        $this->_checkSiteUserFriendTable();
        $this->_checkSiteFriendApplyTable();

        $this->_checkPassportPasswordTable();
        $this->_checkPassportPasswordPreSessionTable();
        $this->_checkPassportPasswordTokenTable();

    }

    private function _checkConfigDefaultValue($siteName, $siteHost, $Port)
    {
//        $loginPluginId = 100;
        $loginPluginId = ZalyConfig::getConfig("loginPluginId");
        $this->_insertSiteLoginPlugin();
        $this->_insertSiteConfig($siteName, $loginPluginId);

        $ownerUic = '000000';
        $this->_insertSiteOwnerUic($ownerUic);

        //admin web
        $this->_insertSiteManagerPlugin($siteHost, $Port);
        //user square
        $this->_insertSiteUserSquarePlugin($siteHost, $Port);

        return;
    }

    private function _checkSiteFriendApplyTable()
    {
        $sql = "CREATE TABLE if not EXISTS siteFriendApply(
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              userId VARCHAR(100) NOT NULL,
              friendId VARCHAR(100) NOT NULL,
              greetings VARCHAR(100),
              applyTime BIGINT,
              UNIQUE(userId, friendId)
        );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteConfigTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteConfig(
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  configKey VARCHAR(100) NOT NULL,
                  configValue TEXT ,
                  UNIQUE (configKey)
                );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSitePluginTable()
    {
        $sql = "
            CREATE TABLE sitePlugin(
              id INTEGER PRIMARY KEY AUTOINCREMENT,
              pluginId INTEGER NOT NULL,
              name VARCHAR(100) NOT NULL, /*名字*/
              logo TEXT NOT NULL,/*logo*/
              sort INTEGER,/*排序 数值越小，排位靠前*/
              landingPageUrl TEXT,/*落地页*/
              landingPageWithProxy LONG, /*是否使用resp加载落地页*/
              usageType INTEGER,          /*功能类型*/
              loadingType INTEGER,/*展现方式*/
               permissionType INTEGER ,    /*使用权限*/
               authKey VARCHAR(32) NOT NULL,
               addTime BIGINT,
               UNIQUE(pluginId,usageType)
              );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSitePluginSort ON sitePlugin(sort);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

    }

    private function _checkSiteUserTable()
    {
        $sql = "CREATE TABLE  IF NOT EXISTS siteUser (
                   id INTEGER PRIMARY KEY AUTOINCREMENT,
                   userId VARCHAR(100) UNIQUE NOT NULL,
                   loginName VARCHAR(100) UNIQUE NOT NULL,
                   loginNameLowercase VARCHAR(100) NOT NULL,
                   nickname VARCHAR(100) NOT NULL,
                   nicknameInLatin VARCHAR(100),
                   avatar VARCHAR(256),
                   availableType INTEGER,
                   countryCode VARCHAR(10),
                   phoneId VARCHAR(11),
                   friendVersion INTEGER,
                   timeReg BIGINT
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteUserFriendTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteUserFriend(
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    userId VARCHAR(100) NOT NULL,
                    friendId VARCHAR(100) NOT NULL,
                    aliasName VARCHAR(100),
                    aliasNameInLatin VARCHAR(100),
                    relation INTEGER,
                    mute BOOLEAN,/*1互为好友 2我删除了对方 3临时会话 */
                    version INTEGER,
                    addTime BIGINT,/*是否静音 1表示静音，0表示没有静音*/
                    UNIQUE(userId, friendId)
                );";

        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteSessionTable()
    {
        $sql = "create table IF NOT EXISTS siteSession(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                sessionId VARCHAR(100) UNIQUE NOT NULL,
                userId VARCHAR(100) NOT NULL,
                deviceId VARCHAR(100) NOT NULL,
                devicePubkPem TEXT, -- DEVICE PUBK PEM
                clientSideType INTEGER,     -- 0:手机客户端  1:web客户端
                timeWhenCreated BIGINT,/*创建时间*/
                ipWhenCreated VARCHAR(100),/*创建时候的ip*/
                timeActive BIGINT,/*最后活跃时间*/
                ipActive VARCHAR(100),/*活跃时间的IP*/
                userAgent VARCHAR(100),
                userAgentType INTEGER,
                gatewayURL VARCHAR(100),
                gatewaySocketId VARCHAR(100),
                UNIQUE(sessionId,userId)
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSiteSessionUserId ON siteSession('userId');";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteGroupTable()
    {
        $sql = "
                CREATE TABLE  IF NOT EXISTS siteGroup (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               groupId VARCHAR(100) NOT NULL,/*6到16位*/
               `name` VARCHAR(100) NOT NULL,/*群名*/
               nameInLatin VARCHAR(100) NOT NULL,
               owner VARCHAR(100) NOT NULL,
               avatar VARCHAR(256),/*群头像*/
               description TEXT,/*群描述*/
               descriptionType INTEGER default 0,/*descrption type， 0 text, 1 md*/
               permissionJoin INTEGER,/*加入方式*/
               canGuestReadMessage BOOLEAN,/*游客是否允许读群消息*/
               maxMembers INTEGER,/*群最大成员数*/
               speakers TEXT, /*发言人*/
                status INTEGER default 1,/*表示群的状态， 1表示正常*/
                isWidget INTEGER default 0, /*表示1是挂件，0不是挂件*/
               timeCreate BIGINT,
               UNIQUE(groupId)
        );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteGroupUserTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteGroupUser(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
               groupId VARCHAR(100) NOT NULL,
               userId VARCHAR(100) NOT NULL,
               memberType INTEGER,
               isMute BOOLEAN default 0 ,/*是否静音 1表示静音，0表示没有静音*/
               timeJoin BIGINT,
               UNIQUE(groupId, userId)
        );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteU2MessageTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteU2Message(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            msgId VARCHAR(100) UNIQUE NOT NULL, 
            userId VARCHAR(100) NOT NULL, 
            fromUserId VARCHAR(100),
            toUserId VARCHAR(100) NOT NULL,
            roomType INTEGER,
            msgType INTEGER, 
            content TEXT,   -- 可能是一个json，可能是一个proto toString
            msgTime BIGINT
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSiteU2MessageUserId ON siteU2Message(userId);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteU2MessagePointerTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteU2MessagePointer(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            userId VARCHAR(100) NOT NULL,
            deviceId VARCHAR(100),
            clientSideType INTEGER,     -- 0:无效，1:手机客户端  2:web客户端
            pointer INTEGER      
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE UNIQUE INDEX IF NOT EXISTS indexSiteU2MessagePointerUd ON siteU2MessagePointer(userId,deviceId);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkSiteGroupMessageTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteGroupMessage(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            msgId VARCHAR(100) UNIQUE NOT NULL,
            groupId VARCHAR(100) NOT NULL,
            fromUserId VARCHAR(100),
            msgType INTEGER,
            content TEXT,
            msgTime BIGINT
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSiteGroupMessageGroupId ON siteGroupMessage(groupId);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkPassportPasswordTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS passportPassword(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                userId VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                password VARCHAR(100) NOT NULL,
                nickname VARCHAR(100) NOT NULL,
                loginName VARCHAR(100) NOT NULL,
                invitationCode VARCHAR(100),
                timeReg BIGINT,
                unique(userId),
                unique(email),
                unique(loginName)
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkPassportPasswordPreSessionTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS passportPasswordPreSession(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                userId VARCHAR(100) NOT NULL,
                preSessionId VARCHAR(100) NOT NULL,
                sitePubkPem TEXT,
                unique(userId)
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _checkPassportPasswordTokenTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS passportPasswordToken(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                loginName VARCHAR(100) NOT NULL,
                token VARCHAR(100) NOT NULL,
                timeReg BIGINT,
                UNIQUE(loginName)
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }


    private function _checkSiteGroupMessagePointerTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteGroupMessagePointer(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            groupId VARCHAR(100) NOT NULL,
            userId VARCHAR(100) NOT NULL,
            deviceId VARCHAR(100),
            clientSideType INTEGER, -- 0:无效，1:手机客户端  2:web客户端
            pointer INTEGER
            );";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSiteGroupMessagePointerGud ON siteGroupMessagePointer(groupId,userId,deviceId);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

    }


    private function _checkSiteUicTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteUic(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code VARCHAR(50) unique NOT NULL,
            userId VARCHAR(100),
            status INTEGER, -- 0：无效，1：所有人可用 2：会员可用等
            createTime BIGINT,
            useTime BIGINT
            );";

        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $indexSql = "CREATE INDEX IF NOT EXISTS indexSiteUicUserId ON siteUic(userId);";
        $prepare = $this->db->prepare($indexSql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }


    private function _insertSiteConfig($siteName, $loginPluginId)
    {
        $siteConfig = SiteConfig::$siteConfig;

        $siteConfig[SiteConfig::SITE_NAME] = $siteName;

        $siteConfig[SiteConfig::SITE_ENABLE_INVITATION_CODE] = 1;//init with uic when first user login

        $siteConfig[SiteConfig::SITE_LOGIN_PLUGIN_ID] = $loginPluginId;

        $siteConfig[SiteConfig::SITE_PLUGIN_PLBLIC_KEY] = (new ZalyHelper())->generateStrKey(32);

        $pubkAndPrikPems = SiteConfig::getPubkAndPrikPem();
        $siteConfig = array_merge($siteConfig, $pubkAndPrikPems);

        $sqlStr = "";
        foreach ($siteConfig as $configKey => $configVal) {
            $sqlStr .= "('$configKey','$configVal'),";
        }
        $sqlStr = trim($sqlStr, ",");
        $sql = "insert into 
                        siteConfig(configKey, configValue) 
                    values 
                        $sqlStr;";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _insertSiteOwnerUic($code = "000000")
    {
        $timeStamp = $this->helper->getMsectime();
        $sql = "insert into siteUic(code,status,createTime) values('$code',100,$timeStamp)";
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _insertSiteLoginPlugin()
    {
        $sql = 'insert into
                    sitePlugin(pluginId, name, logo, sort, landingPageUrl,landingPageWithProxy,usageType,loadingType,permissionType,authKey)
                values
                    (100,
                    "登录注册页面",
                    "", 
                    100,
                    "http://open.akaxin.com:5208/index.php?action=page.login",
                    0,
                    ' . Zaly\Proto\Core\PluginUsageType::PluginUsageLogin . ', 
                    ' . Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage . ', 
                    ' . Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll . ',
                    "");
                ';

        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $sql = 'insert into
                    sitePlugin(pluginId, name, logo, sort, landingPageUrl,landingPageWithProxy, usageType,loadingType,permissionType,authKey)
                values
                    (105,
                    "密码账号注册页面",
                    "", 
                    105,
                    "index.php?action=page.loginSite",
                    1,
                     ' . Zaly\Proto\Core\PluginUsageType::PluginUsageLogin . ', 
                     ' . Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage . ', 
                     ' . Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll . ',
                     "");
                ';
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();

        $sql = 'insert into
                    sitePlugin(pluginId, name, logo, sort, landingPageUrl,landingPageWithProxy, usageType,loadingType,permissionType,authKey)
                values
                    (106,
                    "gif",
                    "", 
                    106,
                    "index.php?action=plugin.gif",
                    1,
                     ' . Zaly\Proto\Core\PluginUsageType::PluginUsageU2Message . ', 
                     ' . Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage . ', 
                     ' . Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll . ',
                     "");
                ';
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _insertSiteManagerPlugin($host, $port)
    {
        $pluginAddress = "http://" . $host . ":" . $port . "/index.php?action=manage.index";
        $sql = 'insert into
                    sitePlugin(pluginId, name, logo, sort, landingPageUrl, landingPageWithProxy,usageType,loadingType,permissionType,authKey)
                values
                    (101,
                    "manager",
                    "", 
                    1,
                    "' . $pluginAddress . '",
                    1,
                     ' . Zaly\Proto\Core\PluginUsageType::PluginUsageIndex . ', 
                     ' . Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage . ', 
                     ' . Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll . ',
                     "");
                ';
        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);
        $prepare->execute();
    }

    private function _insertSiteUserSquarePlugin($host, $port)
    {
        $pluginAddress = "http://" . $host . ":" . $port . "/index.php?action=manage.index";
        $sql = 'insert into
                    sitePlugin(pluginId, name, logo, sort, landingPageUrl,landingPageWithProxy, usageType,loadingType,permissionType,authKey)
                values
                    (102,
                    "square",
                    "", 
                    2,
                    "' . $pluginAddress . '",
                    1,
                    ' . Zaly\Proto\Core\PluginUsageType::PluginUsageIndex . ', 
                    ' . Zaly\Proto\Core\PluginLoadingType::PluginLoadingNewPage . ', 
                    ' . Zaly\Proto\Core\PluginPermissionType::PluginPermissionAll . ',
                     "");
                ';

        $prepare = $this->db->prepare($sql);
        $this->handelPrepareError($prepare);

        $prepare->execute();
    }

    function handelPrepareError($prepare)
    {
        $this->wpf_Logger = new Wpf_Logger();
        $tag = __CLASS__.'-'.__FUNCTION__;
        if (!$prepare) {
            $error = [
                "error_code" => $this->db->errorCode(),
                "error_info" => $this->db->errorInfo(),
            ];
            $this->wpf_Logger->error($tag, "error_msg=".json_encode($error));
        }
    }
}