HeaderInvalid    = "_0";
HeaderErrorCode  = "_1";
HeaderErrorInfo  = "_2";
HeaderSessionid  = "_3";
HeaderHostUrl    = "_4";
HeaderReferer    = "_5";
HeaderUserAgent  = "_6";
HeaderAllowCache = "_7";
HeaderUserClientLang = "_8";
HeaderApplicationVersion = "_10";

MessageType = {
    MessageInvalid : "MessageInvalid",
    MessageNotice  : "MessageNotice",
    MessageText    : "MessageText",
    MessageImage   : "MessageImage",
    MessageAudio   : "MessageAudio",
    MessageWeb     : "MessageWeb",
    MessageWebNotice : "MessageWebNotice",

    // event message start
    MessageEventFriendRequest : "MessageEventFriendRequest",
    MessageEventStatus  : "MessageEventStatus",   // -> StatusMessage
    MessageEventSyncEnd :"MessageEventSyncEnd",

};

MessageTypeNum = {
    MessageInvalid : 0,
    MessageNotice  : "1",
    MessageText    : "2",
    MessageImage   : "3",
    MessageAudio   : "4",
    MessageWeb     : "5",
    MessageWebNotice : "6",

    // event message start
    MessageEventFriendRequest : "MessageEventFriendRequest",
    MessageEventStatus  : "MessageEventStatus",   // -> StatusMessage
    MessageEventSyncEnd :"MessageEventSyncEn",
};

FriendRelation = {
    FriendRelationInvalid : "FriendRelationInvalid",
    FriendRelationFollow  : "FriendRelationFollow",
    FriendRelationFollowForGroup : "FriendRelationFollowForGroup",
    FriendRelationFollowForWeb   : "FriendRelationFollowForWeb",
}


MessageStatus  = {
    MessageStatusSending : "MessageStatusSending",
    MessageEventStatus : "MessageEventStatus",
    MessageStatusFailed : "MessageStatusFailed",
    MessageStatusServer : "MessageStatusServer",
    MessageEventSyncEnd : "MessageEventSyncEnd",
}

DataWriteType = {
    WriteUpdate : "WriteUpdate",
    WriteAdd : "WriteAdd",
    WriteDel : "WriteDel"
}

FileType =  {
    FileInvalid : "FileInvalid",
    FileImage : "FileImage", // the server should find the exactly extension, ex: http://php.net/manual/en/function.mime-content-type.php
    FileAudio : "FileAudio", // the server should find the exactly extension, ex: http://php.net/manual/en/function.mime-content-type.php
}

ApiGroupUpdateType  = {
    ApiGroupUpdateInvalid : "ApiGroupUpdateInvalid",
    ApiGroupUpdateName    : "ApiGroupUpdateName",
    ApiGroupUpdatePermissionJoin : "ApiGroupUpdatePermissionJoin",
    ApiGroupUpdateCanGuestReadMessage : "ApiGroupUpdateCanGuestReadMessage",
    ApiGroupUpdateDescription : "ApiGroupUpdateDescription",
    ApiGroupUpdateAdmin      : "ApiGroupUpdateAdmin",
    ApiGroupUpdateSpeaker     : "ApiGroupUpdateSpeaker",
    ApiGroupUpdateIsMute      : "ApiGroupUpdateIsMute"
}

GroupJoinPermissionType  = {
    GroupJoinPermissionPublic   : "GroupJoinPermissionPublic",
    GroupJoinPermissionMember   : "GroupJoinPermissionMember",
    GroupJoinPermissionAdmin    : "GroupJoinPermissionAdmin",
}

GroupDescriptionType  = {
    GroupDescriptionText : "GroupDescriptionText",
    GroupDescriptionMarkdown : "GroupDescriptionMarkdown",
}

GroupMemberType = {
    GroupMemberGuest    : "GroupMemberGuest",
    GroupMemberNormal   : "GroupMemberNormal",
    GroupMemberAdmin    : "GroupMemberAdmin",
    GroupMemberOwner    : "GroupMemberOwner",
}

ApiFriendUpdateType =  {
    ApiFriendUpdateInvalid  : "ApiFriendUpdateInvalid",
    ApiFriendUpdateRemark   : "ApiFriendUpdateRemark",
    ApiFriendUpdateIsMute   : "ApiFriendUpdateIsMute",
}


KeepSocket  = "KeepSocket";
websocketGW = "enable_websocket_gw";
websocketGWUrl = "websocket_gw_url";

ErrorSessionCode = "error.session";
PageLoginAction  = "page.index";

sessionId = $(".session_id").attr("data");
domain    = $(".domain").attr("data");

siteConfigKeys = {
    logo : "logo",
    name : "name",
    respGW : "respGW",
    httpGW : "httpGW",
    masters : "masters",
    serverAddressForIM : "serverAddressForIM",
    loginPluginId : "loginPluginId",
    enableTmpChat :"enableTmpChat",
    enableRealName : "enableRealName",
    enableWidgetWeb : "enableWidgetWeb",
    siteIdPubkBase64 : "siteIdPubkBase64",
    enableCreateGroup : "enableCreateGroup",
    enableInvitationCode: "enableInvitationCode",
};
siteConfigKey = "site_config";
siteLoginPluginKey = "site_login_plugin";

// CONNECTING：值为0，表示正在连接。
// OPEN：值为1，表示连接成功，可以通信了。
// CLOSING：值为2，表示连接正在关闭。
// CLOSED：值为3，表示连接已经关闭，或者打开连接失败。

WS_CONNTENTING = 0;
WS_OPEN = 1;
WS_CLOSING = 2;
WS_CLOSED = 3;
PACKAGE_ID = "packageId";
lockReconnect = false;

U2_MSG = "MessageRoomU2";
GROUP_MSG = "MessageRoomGroup";
roomKey  = "room_";
roomMsgUnReadNum = "room_msg_unread_num_";
roomListMsgUnReadNum = "room_list_msg_unread_num";
roomListKey = "room_list";
MaxStorageStore=3;

DISPLAY_CHAT = "chat";
DISPLAY_APPLY_FRIEND_LIST = "apply_friend_list";


currentGroupProfileKey = "current_group_profile";
defaultCountKey = 200;

chatSessionIdKey = "chat_session_id";
localPotiner    = "group_pointer_";
profileKey = "profile_";
friendRelationKey = "user_id_relation_";
msgMuteKey = "msg_mute_";
msgUnReadMuteKey = "msg_unread_mute_";
roomListMsgMuteUnReadNumKey = "room_list_msg_mute_unread_num";
applyFriendListNumKey = "apply_friend_list_num";
chatTypeKey = "chat_type";
WidgetChat = "widget_chat";
DefaultChat = "default_chat";
MobileChat = "mobile_chat";

DefaultTitle = "DuckChat 聊天室";

////session Storage
userIdsKey  = "user_ids";
groupIdsKey = "group_ids";
sendMsgImgUrlKey = "msg_img_url_";
msgIdInChatSessionKey = "msgId_in_chatSession_";
reqProfile = "req_profile_";


uploadImgForMsg  = "uploadImgForMsg";
uploadImgForSelfAvatar = "uploadImgForSelfAvatar";

ProfileTimeout =  1000*60*60*24*30;////1个月
reqTimeout = 1000*60*5;///5分钟

defaultUserName = "匿名";

