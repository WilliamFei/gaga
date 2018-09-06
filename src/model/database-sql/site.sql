
/**
 * site config table
 */
CREATE TABLE IF NOT EXISTS siteConfig(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  configKey VARCHAR(100) NOT NULL,
  configValue VARCHAR(100) NOT NULL,
  UNIQUE (configKey)
);


/**
 * site plugin manager  table
 */
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
              );
CREATE INDEX IF NOT EXISTS indexSitePluginSort ON sitePlugin("sort");


/*默认插入insert*/
insert into
  sitePlugin(name, logo, sort, landingPageUrl, usageType,loadingType,permissionType,authKey)
values
  ("登录注册页面","", 1, "http://127.0.0.1:5208/index.php?action=page.login", 2, 0, 1,"");


CREATE TABLE IF NOT EXISTS siteUser(
    id INTEGER PRIMARY KEY  AUTOINCREMENT,
    userId VARCHAR(32) NOT NULL,/*id*/
    loginName VARCHAR(100) NOT NULL ,/*用户名 英文数字*全局唯一*/
    nickname VARCHAR(100) NOT NULL ,/*用户昵称*/
    nicknameInLatin VARCHAR(100),/*用户昵称 拉丁 排序*/
    avatar VARCHAR(256),
    availableType INTEGER,
    phone varchar(11),
    timeReg BIGINT,
    UNIQUE(userId),
    UNIQUE(username)
  );

create table IF NOT EXISTS siteSession(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sessionId VARCHAR(100) UNIQUE NOT NULL,
    userId VARCHAR(100) NOT NULL,
    deviceId VARCHAR(100) NOT NULL,
    clientSideType INTEGER,     -- 0:手机客户端  1:web客户端
    timeWhenCreated BIGINT,/*创建时间*/
    ipWhenCreated VARCHAR(100),/*创建时候的ip*/
    timeActive BIGINT,/*最后活跃时间*/
    ipActive VARCHAR(100),/*活跃时间的IP*/
    siteUserToken VARCHAR(100),/*push token 平台下发*/
    userAgent VARCHAR(100),
    userAgentType INTEGER,
    gatewayURL VARCHAR(100),
    gatewaySocketId VARCHAR(100),
    UNIQUE(sessionId,userId)
);

CREATE INDEX IF NOT EXISTS indexSiteSessionUserId ON siteSession(userId);


-- groupTable
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
       speakers TEXT,
       timeCreate BIGINT,
       status INTEGER ,/*表示群的状态，0 删除， 1表示正常*/
       UNIQUE(groupId)
);

CREATE TABLE IF NOT EXISTS siteGroupUser(
       id INTEGER PRIMARY KEY AUTOINCREMENT,
       groupId VARCHAR(100) NOT NULL,
       userId VARCHAR(100) NOT NULL,
       memberType INTEGER,
       isMute BOOLEAN,/*是否静音 1表示静音，0表示没有静音*/
       timeJoin BIGINT,
       UNIQUE(groupId, userId)
);

CREATE TABLE  IF NOT EXISTS  siteUserFriend(
      id INTEGER PRIMARY KEY NOT NULL,
      userId VARCHAR(100) not null,
      friendId VARCHAR(100) not null,
      relation INTEGER,/*1互为好友 2对方将我删除 3临时会话 */
      isMute BOOLEAN,/*是否静音 1表示静音，0表示没有静音*/
      addTime BIGINT
);

CREATE UNIQUE INDEX indexUserFriend ON siteUserFriend(userId,friendId);



-- group message table

CREATE TABLE IF NOT EXISTS siteGroupMessage(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            msgId VARCHAR(100) UNIQUE NOT NULL,
            groupId VARCHAR(100) NOT NULL,
            fromUserId VARCHAR(100),
            msgType INTEGER,
            content TEXT,   -- 可能是一个json，可能是一个proto toString
            msgTime BIGINT
            );

CREATE INDEX IF NOT EXISTS indexSiteGroupMessageGroupId ON siteGroupMessage(groupId);

CREATE TABLE IF NOT EXISTS siteGroupMessagePointer(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            groupId VARCHAR(100) NOT NULL,
            userId VARCHAR(100) NOT NULL,
            deviceId VARCHAR(100),
            clientSideType INTEGER,     -- 0:手机客户端  1:web客户端
            pointer INTEGER
            );

CREATE INDEX IF NOT EXISTS indexSiteGroupMessagePointerGud ON siteGroupMessagePointer(groupId,userId,deviceId);


CREATE TABLE IF NOT EXISTS siteUic(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code VARCHAR(50) unique NOT NULL,
            userId VARCHAR(100),
            status INTEGER, -- 0：无效，1：所有人可用 2：会员可用等
            createTime BIGINT,
            useTime BIGINT
            );

CREATE INDEX IF NOT EXISTS indexSiteUicUserId ON siteUic(userId);
