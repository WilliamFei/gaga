

msgImageSize = "";

isSyncingMsg = false;

function getRoomList()
{
    var roomList = handleRoomListFromLocalStorage(undefined);
    $(".chatsession-lists").html("");
    if(roomList == undefined || roomList.length == 0) {
        var html = template("tpl-room-no-data", {});
        $(".chatsession-lists").html(html);
        displayRightPage(DISPLAY_CHAT);
        return ;
    }

    var length = roomList.length;
    var currentChatSessionId  = localStorage.getItem(chatSessionIdKey);
    getMsgFromRoom(currentChatSessionId);

    var i;
    for(i=0;i <length; i++) {
        var msg = roomList[i];
        if(!currentChatSessionId &&  i==length-1) {
            localStorage.setItem(chatSessionIdKey, msg.chatSessionId);
        }
        if( msg.chatSessionId == currentChatSessionId) {
            localStorage.setItem( msg.chatSessionId, msg.roomType);
        }
        msg = handleMsgInfo(msg);
        appendOrInsertRoomList(msg, false);
    }
    displayCurrentProfile();
    displayRightPage(DISPLAY_CHAT);
    msgBoxScrollToBottom();
}


function handleRoomListFromLocalStorage(roomMsg)
{
    try{
        var roomListStr = localStorage.getItem(roomListKey);
        var roomList;
        if(roomListStr) {
            roomList = JSON.parse(roomListStr);
        } else {
            roomList = new Array();
        }
        var isUpdate =false;

        if(roomMsg != undefined) {
            var length = roomList.length;
            var i;
            for(i =0; i<length;  i++) {
                var msg = roomList[i];
                if(msg!=null&& msg!= false && msg.hasOwnProperty("chatSessionId") && msg.chatSessionId == roomMsg.chatSessionId) {
                    if(msg.timeServer < roomMsg.timeServer) {
                        if(roomMsg.hasOwnProperty("text") && roomMsg["text"].body.length < 1){
                            msg.timeServer = roomMsg.timeServer;
                        } else {
                            msg = roomMsg;
                        }
                        roomList[i] = msg;
                    }
                    isUpdate = true;
                }
            }
            if(!isUpdate) {
                roomList.push(roomMsg);
            }
        }
        roomList.sort(compare);
        localStorage.setItem(roomListKey, JSON.stringify(roomList));
        return roomList;
    }catch (error) {
        storageError(error);
    }
}

function removeRoomFromRoomList(chatSessionId)
{
    var roomListStr = localStorage.getItem(roomListKey);
    var roomList;
    if(roomListStr) {
        roomList = JSON.parse(roomListStr);
    } else {
        roomList = new Array();
    }
    if(chatSessionId != undefined) {
        var length = roomList.length;
        var i;
        for(i =0; i<length;  i++) {
            var msg = roomList[i];
            if(msg!=null && msg != false &&  msg.hasOwnProperty("chatSessionId") && msg.chatSessionId == chatSessionId) {
                roomList.splice(i, 1);
            }
        }
    }
    roomList.sort(compare);
    localStorage.setItem(roomListKey, JSON.stringify(roomList));
    return roomList;
}

function appendOrInsertRoomList(msg, isInsert)
{
    if(msg != undefined && msg.hasOwnProperty("type") && msg.type == MessageStatus.MessageEventSyncEnd) {
        return ;
    }
    var unReadNum = localStorage.getItem(roomMsgUnReadNum + msg.chatSessionId) ? localStorage.getItem(roomMsgUnReadNum + msg.chatSessionId): 0;
    unReadNum  = unReadNum > 99 ? "99+" : unReadNum;
    var name   =  msg.roomType == GROUP_MSG ? msg.name : msg.nickname;
    var msgType = msg.msgType != undefined ? msg.msgType : msg.type;
    var msgContent;

    switch (msgType) {
        case MessageTypeNum.MessageText:
        case MessageType.MessageText:
            msgContent = msg.hasOwnProperty("text") ? msg['text'].body: JSON.parse(msg['content']).body;
            msgContent = msgContent && msgContent.length > 10 ? msgContent.substr(0,10)+"..." : msgContent;
            break;
        case MessageTypeNum.MessageImage:
        case MessageType.MessageImage:
            msgContent = "[图片消息]";
            break;
        case MessageType.MessageNotice:
            msgContent = msg["notice"].body;
            msgContent = msgContent && msgContent.length > 10 ? msgContent.substr(0,10)+"..." : msgContent;
            break;
        case MessageType.MessageWeb:
            msgContent = "[" + msg["web"].title + "]";
            msgContent = msgContent && msgContent.length > 10 ? msgContent.substr(0,10)+"..." : msgContent;
            break;
    }

    var nodes = $(".chat_session_id_" + msg.chatSessionId);
    var msgTime = msg.msgTime != undefined ? msg.msgTime : msg.timeServer;
    msgTime = getRoomMsgTime(msgTime);

    if(isInsert) {
        handleRoomListFromLocalStorage(msg);
    }

    if(nodes.length) {
        if($(nodes).attr("msg_time") < msg.timeServer) {
            var childrens = $(nodes)[0].children;
            var unReadNum = getRoomMsgUnreadNum(msg.chatSessionId);
            var isMuteNum = localStorage.getItem(msgUnReadMuteKey+msg.chatSessionId);
            var isMute = localStorage.getItem(msgMuteKey+msg.chatSessionId);
            if(isMuteNum == 1 && isMute == 1) {
                $(".room-chatsession-unread_"+msg.chatSessionId)[0].style.display = "none";
                $(".room-chatsession-mute-num_"+msg.chatSessionId)[0].style.display = "block";
            } else {
                 if(unReadNum>0 && (msg.chatSessionId != localStorage.getItem(chatSessionIdKey))) {
                    $(".room-chatsession-unread_"+msg.chatSessionId).html(unReadNum);
                    $(".room-chatsession-unread_"+msg.chatSessionId)[0].style.display = "block";
                    $(".room-chatsession-mute-num_"+msg.chatSessionId)[0].style.display = "none";
                }
            }
            if(msgContent != undefined && msgContent.length>1) {
                $(childrens[2]).html(msgContent);
            }

            var subChildrens = $(childrens[1])[0].children;
            $(subChildrens[1]).html(msgTime);
            sortRoomList($(nodes));
        }
        if(msg.chatSessionId == localStorage.getItem(chatSessionIdKey)) {
            $(".chat_session_id_"+msg.chatSessionId).addClass("chatsession-row-active");
        }
        return ;
    }

    var avatar = msg.roomType == GROUP_MSG ? msg.avatar : msg.userAvatar;

    var html = template("tpl-chatSession", {
        className:msg.roomType == U2_MSG ? "u2-profile" : "group-profile",
        isMute:msg.isMute,
        isMuteMsgNum:msg.isMuteMsgNum,
        chatSessionId:msg.chatSessionId,
        roomType:msg.roomType,
        name:name,
        msgTime:msgTime,
        msgContent : msgContent,
        unReadNum : unReadNum,
        avatar:avatar,
        timeServer:msgTime,
        msgServerTime:msg.timeServer,
    });
    if($(".chatsession-row").length > 0 ) {
        $(html).insertBefore($(".chatsession-row")[0]);
    } else {
        $(".chatsession-lists").html(html);
    }

    msg.roomType == GROUP_MSG ? getNotMsgImg(msg.chatSessionId, msg.avatar) : getNotMsgImg(msg.chatSessionId, msg.userAvatar);

    if(msg.chatSessionId == localStorage.getItem(chatSessionIdKey)) {
        $(".chat_session_id_"+msg.chatSessionId).addClass("chatsession-row-active");
    }
}


function handleMsgInfo(msg)
{
    var toGroupId = msg.toGroupId;
    var groupId = msg.groupId
    var userId;
    var nowTimestamp = Date.parse(new Date());
    if(groupId != undefined || toGroupId != undefined) {
        msg.className = "group-profile";
        msg.chatSessionId = groupId != undefined ? groupId : toGroupId;
        msg.roomType = GROUP_MSG;
        var groupProfile = getGroupProfile(msg.chatSessionId);
        if(groupProfile) {
            msg.name = groupProfile['name'];
            msg.avatar = groupProfile['avatar'];
        }
        userId = msg.fromUserId;
    } else {
        msg.className = "u2-profile";
        if(msg.fromUserId == token) {
            msg.chatSessionId = msg.toUserId;
        } else {
            msg.chatSessionId = msg.fromUserId;
        }
        msg.roomType = U2_MSG;
        userId = msg.chatSessionId;
    }
    var muteKey = msgMuteKey + msg.chatSessionId;
    msg.isMute = localStorage.getItem(muteKey);

    var unreadMuteKey = msgUnReadMuteKey+msg.chatSessionId;
    msg.isMuteMsgNum = localStorage.getItem(unreadMuteKey) == 1 ? 1 : 0;

    var userProfile = getFriendProfile(userId);
    if(userProfile) {
        msg.nickname   = userProfile['nickname'];
        msg.userAvatar = userProfile['avatar'];
    } else {
        msg.nickname = "";
        msg.userAvatar = "";
    }

    return msg;
}

function uniqueMsgAndCheckMsgId(msgList, msgId, roomChatSessionKey)
{
    try{
        var hash = {};
        var repeatMsgId = {};
        msgList = msgList.reduce(function(item, next) {
            hash[next.msgId] ? repeatMsgId[msgId] = true : hash[next.msgId] = true && item.push(next);
            return item
        }, []);
        localStorage.setItem(roomChatSessionKey, JSON.stringify(msgList));

        return repeatMsgId[msgId] ? false : true;
    }catch (error) {
        handleSetItemError(error);
    }
}
function handleSetItemError(error)
{
    if( e.name.toUpperCase().indexOf('QUOTA') >= 0) {
        console.log("error ==" + error.message);
    }
}
enableWebsocketGw = localStorage.getItem(websocketGW);

if(enableWebsocketGw == "false") {
    ///1秒 sync
   setInterval(function (args) {
       enableWebsocketGw = localStorage.getItem(websocketGW);
       if(enableWebsocketGw == "false")  {
           syncMsgForRoom();
       }
   }, 1000);
}

if(enableWebsocketGw == "true") {
    auth();
} else {
    syncMsgForRoom();
}

function auth()
{
    var action = "im.cts.auth";
    handleImSendRequest(action, "", handleAuth);
}

function handleAuth()
{
    syncMsgForRoom();
}

function syncMsgForRoom()
{
    if(isSyncingMsg == true) {
        return ;
    }
    isSyncingMsg = true;
    var action = "im.cts.sync";

    var reqData = {
        "u2Count" : defaultCountKey,
        "groupCount" : defaultCountKey,
    };
    handleImSendRequest(action, reqData, handleSyncMsgForRoom);
}

function handleSyncMsgForRoom(results)
{
    try{
        var list = results.list;
        if(list){
            var length = list.length;
            ////从小到大排序
            list.sort(compare);
            var groupUpdatePointer = {};
            var u2UpdatePointer = 0;
            var i;
            var isNeewUpdatePointer = false;
            for(i=0; i<length; i++) {
                var msg = list[i];
                if(msg.hasOwnProperty("toGroupId") && msg.toGroupId.length>0) {
                    isNeewUpdatePointer = true;
                    var groupId = msg.toGroupId;
                    if(groupUpdatePointer.hasOwnProperty(groupId)) {
                        var pointer = groupUpdatePointer[groupId];
                        if(Number(pointer) < Number(msg.pointer)) {
                            groupUpdatePointer[groupId] = msg.pointer;
                        }
                    } else {
                        groupUpdatePointer[groupId] = msg.pointer;
                    }
                } else {
                    if(msg.pointer != undefined) {
                        isNeewUpdatePointer = true
                        u2UpdatePointer = msg.pointer;
                    }
                }
                handleSyncMsg(msg);
            }
            isSyncingMsg = false;

            if(isNeewUpdatePointer == true) {
                var updateMsgPointerData = {
                    u2Pointer:u2UpdatePointer,
                    groupsPointer : groupUpdatePointer,
                };
                updateMsgPointer(updateMsgPointerData);
            }
        }
    }catch (error) {
        isSyncingMsg = false;
    }
}

function handleSyncMsg(msg)
{
    if(msg.type == MessageType.MessageEventSyncEnd) {
        return ;
    }
    if(msg.type == MessageType.MessageEventStatus) {
        var msgId     = msg.msgId;
        var msgStatus = msg.status["status"];
        handleMsgStatusResult(msgId, msgStatus);
        return;
    }
    if(msg.type == MessageType.MessageEventFriendRequest) {
        getFriendApplyList();
        return;
    };
    var msg = handleMsgInfo(msg);
    var currentChatSessionId = localStorage.getItem(chatSessionIdKey);
    var isNewMsg = handleMsgForMsgRoom(msg.chatSessionId, msg);

    ///是自己群的消息，并且是新消息
    if(msg.chatSessionId  == currentChatSessionId && isNewMsg) {
        appendMsgHtml(msg);
        msgBoxScrollToBottom();
    } else if(msg.chatSessionId != currentChatSessionId && isNewMsg) {
        if(msg.chatSessionId != token) {
            setRoomMsgUnreadNum(msg.chatSessionId);
            setDocumentTitle("new_msg");
        }
    }
    appendOrInsertRoomList(msg, true);
}

function handleMsgStatusResult(msgId, msgStatus)
{
    var msgIdInChatSession = msgIdInChatSessionKey + msgId;
    var chatSessionId = sessionStorage.getItem(msgIdInChatSession);

    if(msgStatus == MessageStatus.MessageStatusFailed) {
        $(".msg_status_failed_"+msgId)[0].style.display = "flex";
        $(".msg_status_loading_"+msgId)[0].style.display = "none";
        $(".msg_status_loading_"+msgId).attr("is-display", "none");
        updateMsgStatus(msgId, chatSessionId, MessageStatus.MessageStatusFailed);
    } else if(msgStatus == MessageStatus.MessageStatusServer) {
        $(".msg_status_loading_"+msgId)[0].style.display = "none";
        $(".msg_status_loading_"+msgId).attr("is-display", "none");
    }
    sessionStorage.removeItem(msgIdInChatSession);
}

function setRoomMsgUnreadNum(chatSessionId)
{
    var mute = localStorage.getItem(msgMuteKey+chatSessionId);
    if(mute == 1) {
        var  unreadMuteKey = msgUnReadMuteKey+chatSessionId;
        if(!localStorage.getItem(unreadMuteKey)) {
            var unReadAllMuteNum =  !localStorage.getItem(roomListMsgMuteUnReadNumKey) ? 1 : (Number(localStorage.getItem(roomListMsgMuteUnReadNumKey))+1);
            localStorage.setItem(roomListMsgMuteUnReadNumKey, unReadAllMuteNum);
        }

        localStorage.setItem(unreadMuteKey, 1);
    }else {
        var unreadKey = roomMsgUnReadNum + chatSessionId;
        var unreadNum = !localStorage.getItem(unreadKey) ? 1 : (Number(localStorage.getItem(unreadKey))+1);
        localStorage.setItem(unreadKey, unreadNum);

        var unReadAllMuteNum = !localStorage.getItem(roomListMsgUnReadNum)? 1 : (Number(localStorage.getItem(roomListMsgUnReadNum))+1);
        localStorage.setItem(roomListMsgUnReadNum, unReadAllMuteNum);
    }
    displayRoomListMsgUnReadNum();
}

function getRoomMsgUnreadNum(chatSessionId)
{
    var unreadKey = roomMsgUnReadNum + chatSessionId;
    var unreadNum = !localStorage.getItem(unreadKey) ? 0 : Number(localStorage.getItem(unreadKey));
    unreadNum = unreadNum > 99 ? "99+" : unreadNum;
    return unreadNum;
}

/**
 *
 * @param chatSessionId
 * @param pushMsg
 * @returns msgList or isNewMsg
 */
function handleMsgForMsgRoom(chatSessionId, pushMsg)
{
    var roomChatSessionKey = roomKey + chatSessionId;
    var msgListJsonStr = localStorage.getItem(roomChatSessionKey);
    var isFlag = moreThanMaxStorageSore(roomChatSessionKey);
    if(isFlag) {
        msgListJsonStr = false;
    }
    var msgList;
    try{
        if(!msgListJsonStr) {
            msgList = new Array();
        } else {
            msgList = JSON.parse(msgListJsonStr);
        }

        while(msgList.length>=300) {
            msgList.shift();
        }

        if(pushMsg != undefined) {
            msgList.push(pushMsg);
            var isNewMsg = uniqueMsgAndCheckMsgId(msgList, pushMsg.msgId, roomChatSessionKey);

            return isNewMsg;
        }
        msgList.sort(compare);
        return msgList;
    }catch (error){
        if(error.name == "QuotaExceededError" || error.name == "ReferenceError") {
            msgList = new Array();
            if(pushMsg != undefined) {
                msgList.push(pushMsg);
                var isNewMsg = uniqueMsgAndCheckMsgId(msgList, pushMsg.msgId, roomChatSessionKey);
                return isNewMsg;
            }
            msgList.sort(compare);
            return msgList;
        }
    }
}

function moreThanMaxStorageSore(item)
{
    var sizeStore = 0;
    var itemData=  window.localStorage.getItem(item);
    if(itemData == false || itemData == undefined || itemData == "") {
        return false;
    }
    sizeStore += itemData.length;
    sizeStore = (sizeStore / 1024 / 1024).toFixed(2)
    if(sizeStore>MaxStorageStore) {
        return true;
    }
    return false;
}


function  updateMsgStatus(msgId, chatSessionId, msgStatus)
{
    var msgList = handleMsgForMsgRoom(chatSessionId, undefined);
    var i;
    var length = msgList.length;

    for(i=0; i<length;i++) {
        var msg = msgList[i];
        if(msg.msgId == msgId) {
            msg.status = msgStatus;
            msgList[i] = msg ;
        }
    }
    var roomChatSessionKey = roomKey + chatSessionId;
    localStorage.setItem(roomChatSessionKey, JSON.stringify(msgList));
}


function updateMsgPointer(reqData)
{
    var action = "im.cts.updatePointer";
    handleClientSendRequest(action, reqData, "");
}

function getMsgFromRoom(chatSessionId)
{
    clearRoomUnreadMsgNum(chatSessionId);

    var msgList = handleMsgForMsgRoom(chatSessionId, undefined);

    $(".right-chatbox").html("");
    if(msgList == null) {
        return;
    }

    if(msgList != null) {
        var length = msgList.length;
        var i;
        for(i=0; i<length; i++) {
            var msg = msgList[i];
            msg = handleMsgInfo(msg);
            appendMsgHtml(msg);
        }
    }
    var jqElement = $(".chat_session_id_"+chatSessionId);
    addActiveForRoomList(jqElement);
    msgBoxScrollToBottom();
}

function clearRoomUnreadMsgNum(chatSessionId)
{
    var roomMuteKey = msgUnReadMuteKey+chatSessionId;
    localStorage.removeItem(roomMuteKey);
    var roomMuteNum = localStorage.getItem(roomListMsgMuteUnReadNumKey) ? Number(localStorage.getItem(roomListMsgMuteUnReadNumKey)) : 0;
    roomMuteNum = (roomMuteNum-1)>0 ? (roomMuteNum-1) : 0;
    localStorage.setItem(roomListMsgMuteUnReadNumKey, roomMuteNum);

    var unreadKey = roomMsgUnReadNum + chatSessionId;
    var unReadNum = localStorage.getItem(unreadKey) ?  Number(localStorage.getItem(unreadKey)) : 0 ;
    var roomListUnreadNum = localStorage.getItem(roomListMsgUnReadNum);
    roomListUnreadNum =  (roomListUnreadNum-unReadNum) >0 ? (roomListUnreadNum-unReadNum) : 0;
    roomListUnreadNum =  (roomListUnreadNum-unReadNum) >99 ? "99+": roomListUnreadNum;

    localStorage.setItem(roomListMsgUnReadNum,roomListUnreadNum);
    localStorage.removeItem(unreadKey);

    if($(".room-chatsession-unread_"+chatSessionId)[0]) {
        $(".room-chatsession-unread_"+chatSessionId)[0].style.display = "none";
        $(".room-chatsession-mute-num_"+chatSessionId+"")[0].style.display = "none";
    }
    setDocumentTitle("clear");
}

function compare(msg1, msg2) {
    if (msg1.timeServer < msg2.timeServer)
        return -1;
    if (msg1.timeServer > msg2.timeServer)
        return 1;
    return 0;
}


function getMsgTime()
{
    var date = new Date(); //获取一个时间对象
    var minutes =  date.getMinutes()>=10 ? date.getMinutes():"0"+date.getMinutes();
    var month = date.getMonth() >=10 ? date.getMonth() : "0"+date.getMonth();
    return date.getFullYear() + '-' + month + '-' +date.getDate() + " " + date.getHours()+":"+minutes;  // 获取完整的年份(4位,1970)
}

function getMsgTimeByMsg(time)
{
    time = Number(time);
    var date = new Date(time); //获取一个时间对象
    var minutes =  date.getMinutes()>=10 ? date.getMinutes():"0"+date.getMinutes();
    var month = date.getMonth() >=10 ? date.getMonth() : "0"+date.getMonth();

    return date.getFullYear() + '-' + month + '-' +date.getDate() + " " + date.getHours()+":"+minutes;  // 获取完整的年份(4位,1970)
}

function getRoomMsgTime(time)
{
    time = Number(time);
    var date = new Date(time); //获取一个时间对象
    var minutes =  date.getMinutes()>=10 ? date.getMinutes():"0"+date.getMinutes();
    return date.getHours()+":"+minutes;
}

function sendMsg( chatSessionId, chatSessionType, msgContent, msgType)
{
    var action = "im.cts.message";
    var msgId  = Date.now();

    var message = {};
    message['fromUserId'] = token;
    var msgIdSuffix = "";
    if(chatSessionType == U2_MSG) {
        message['roomType'] = U2_MSG;
        message['toUserId'] = chatSessionId
        msgIdSuffix = "U2-";
    } else {
        message['roomType'] = GROUP_MSG;
        message['toGroupId'] = chatSessionId;
        msgIdSuffix = "GROUP-";
    }
    var msgId = msgIdSuffix + msgId+"";
    message['msgId'] = msgId;

    message['timeServer'] = Date.parse(new Date());

    switch (msgType) {
        case MessageType.MessageText:
            message['text'] = {body:msgContent};
            message['type'] = MessageType.MessageText;
            displayContent = msgContent;
            break;
        case MessageType.MessageImage:
            console.log("MessageType.MessageImage msgImageSize==" + JSON.stringify(msgImageSize));
            message['type'] = MessageType.MessageImage;
            message['image'] = {url:msgContent, width:msgImageSize.width, height:msgImageSize.height};
            displayContent = "[图片消息]";
            break;
    }

    var reqData = {
        "message" : message
    };
    var msgIdInChatSession = msgIdInChatSessionKey + msgId;
    sessionStorage.setItem(msgIdInChatSession, chatSessionId);

    handleImSendRequest(action, reqData, handleMsgSendStatus);
    message['chatSessionId'] = chatSessionId;
    appendOrInsertRoomList(message, true);
    handleMsgForMsgRoom(chatSessionId, message);
    addMsgToChatDialog(chatSessionId, message);
};

function handleMsgSendStatus(results) {
    console.log("results ===" + JSON.parse(results));
}

function addMsgToChatDialog(chatSessionId, msg)
{
    msg.status = MessageStatus.MessageStatusSending;
    appendMsgHtml(msg);

    var node = $(".chat_dession_id_"+chatSessionId);
    sortRoomList(node);
    setTimeout(function () {
        var msgLoadings = $("[is-display='yes']");
        var length = msgLoadings.length;
        var i;
        for(i=0;i<length;i++) {
            var msgLoading = msgLoadings[i];
            $(msgLoading)[0].style.display = "none";
            var msgId = $(msgLoading).attr("msgId");
            $(".msg_status_failed_"+msgId)[0].style.display = "flex";
            handleMsgStatusResult(msgId, MessageStatus.MessageStatusFailed);
        }
    }, 10000);///10秒执行

    msgBoxScrollToBottom();
}

function appendMsgHtml(msg)
{
    if(msg == undefined) {
        return;
    }
    var html = "";
    var msgType = msg.type;
    var msgId = msg.msgId;

    var groupId = msg.toGroupId;
    var sendBySelf;
    var userId;
    if(groupId != undefined && msg.fromUserId != token) {
        sendBySelf = false;
        userId = msg.fromUserId;
    } else if (groupId != undefined && msg.fromUserId == token) {
        sendBySelf = true;
        userId = token;
    }
    if(groupId == undefined && msg.fromUserId != token) {
        sendBySelf = false;
        userId = msg.fromUserId;
    } else if(groupId == undefined && msg.fromUserId == token) {
        sendBySelf = true;
        userId = token;
    }
    var userAvatar;
    var msgTime = getMsgTimeByMsg(msg.timeServer);
    var groupUserImageClassName = msg.roomType == GROUP_MSG ? "group-user-img" : "";
    var msgStatus = msg.status ? msg.status : "";
    var userAvatar = sendBySelf ? avatar : msg.userAvatar;
    if(sendBySelf) {
        switch(msgType) {
            case MessageType.MessageText :
                var msgContent = msg['text'].body;
                html = template("tpl-send-msg-text", {
                    roomType: msg.roomType,
                    nickname:nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    msgContent:msgContent,
                    msgStatus:msgStatus,
                    avatar:userAvatar,
                    userId:token
                });
                break;
            case MessageType.MessageImage :
                var imgObject = getMsgSizeForDiv(msg);
                html = template("tpl-send-msg-img", {
                    roomType: msg.roomType,
                    nickname:nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    msgStatus:msgStatus,
                    avatar:userAvatar,
                    width:imgObject.width,
                    height:imgObject.height,
                    userId:token
                });
                break;
            case MessageType.MessageWebNotice:
                html =  msg['notice'].code;
                break;
            case MessageType.MessageWeb :
                var hrefUrl = getWebMsgHref(msg.msgId, msg.roomType);
                html = template("tpl-send-msg-web", {
                    roomType: msg.roomType,
                    nickname: msg.nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    userId :msg.fromUserId,
                    groupUserImg : groupUserImageClassName,
                    avatar:userAvatar,
                    hrefURL:hrefUrl,
                    userId:token
                });
                break;
            case MessageType.MessageNotice:
                var msgContent = msg["notice"].body;
                html = template("tpl-receive-msg-notice", {
                    msgContent:msgContent,
                });
                break;
        }
    } else {
        switch(msgType) {
            case MessageType.MessageText:
                var msgContent = msg['text'].body;
                html = template("tpl-receive-msg-text", {
                    roomType: msg.roomType,
                    nickname: msg.nickname,
                    msgId : msgId,
                    userId :msg.fromUserId,
                    msgTime : msgTime,
                    msgContent:msgContent,
                    groupUserImg : groupUserImageClassName,
                    avatar:msg.userAvatar,
                });
                break;
            case MessageType.MessageImage :
                var imgObject = getMsgSizeForDiv(msg);
                html = template("tpl-receive-msg-img", {
                    roomType: msg.roomType,
                    nickname: msg.nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    userId :msg.fromUserId,
                    groupUserImg : groupUserImageClassName,
                    avatar:msg.userAvatar,
                    width:imgObject.width,
                    height:imgObject.height,
                });
                break;
            case MessageType.MessageWebNotice :
                // html =  msg['webNotice'].code;
                var hrefUrl = getWebMsgHref(msg.msgId, msg.roomType);
                html = template("tpl-receive-msg-web-notice", {
                    roomType: msg.roomType == GROUP_MSG ? 1 : 0,
                    nickname: msg.nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    userId :msg.fromUserId,
                    groupUserImg : groupUserImageClassName,
                    avatar:msg.userAvatar,
                    hrefURL:hrefUrl
                });
                break;
            case MessageType.MessageWeb :
                // html = "请前往客户端查看web消息";
                var hrefUrl = getWebMsgHref(msg.msgId, msg.roomType);
                html = template("tpl-receive-msg-web", {
                    roomType: msg.roomType,
                    nickname: msg.nickname,
                    msgId : msgId,
                    msgTime : msgTime,
                    userId :msg.fromUserId,
                    groupUserImg : groupUserImageClassName,
                    avatar:msg.userAvatar,
                    hrefURL:hrefUrl
                });
                break;
            case MessageType.MessageNotice:
                var msgContent = msg["notice"].body;
                html = template("tpl-receive-msg-notice", {
                    msgContent:msgContent,
                });
                break;
        }
    }
    if(msgType == MessageType.MessageText) {
        html = trimMsgContentBr(html);
    }

    // html = "请前往客户端查看web消息";
    $(".right-chatbox").append(html);
    $(".msg_content").val('');
    getNotMsgImg(userId, userAvatar);
    getMsgImgSrc(msg, msgId);
}

function trimMsgContentBr(html)
{
    html = html.replace(new RegExp('\n','g'),"<br>");
    html = html.replace(new RegExp('^\\<br>+', 'g'), '');
    html = html.replace(new RegExp('\\<br>+$', 'g'), '');
    return html;
}
function getMsgImgSrc(msg, msgId)
{
    if(msg.hasOwnProperty("image")) {
        var imgId = msg['image'].url;
        var imgUrlKey = sendMsgImgUrlKey + imgId;
        var src =  localStorage.getItem(imgUrlKey);
        if(!src) {
            var isGroupMessage = msg.roomType == GROUP_MSG ? 1 : 0;
            getMsgImg(imgId, isGroupMessage, msgId);
        } else {
            $(".msg-img-"+msgId).attr("src", src);
        }
        localStorage.removeItem(imgUrlKey);
    }
}

function getMsgSizeForDiv(msg)
{
    var chatType = localStorage.getItem(chatTypeKey);
    var h;
    var w;
    if(chatType != DefaultChat) {
        h = 300;
        w = 200;
    } else {
        h = 400;
        w = 300;
    }
    return getMsgSize(msg['image'].width, msg['image'].height, h, w);
}
function getWebMsgHref(msgId, msgRoomType)
{
    var url = "./index.php?action=http.file.downloadWebMsg&msgId="+msgId+"&isGroupMessage="+(msgRoomType==GROUP_MSG ? 1 : 0);
    return url;
}

function msgBoxScrollToBottom()
{
    var rightchatBox = $(".right-chatbox")[0];
    var sh = rightchatBox.scrollHeight;
    var ch  = rightchatBox.clientHeight;
    var scrollTop = sh-ch;
    $(".right-chatbox").scrollTop(scrollTop);

}

function uploadMsgImgFromInput(obj) {

    console.log(" upload msg from " + obj.files.length)

    if (obj) {
        if (obj.files) {
            formData = new FormData();

            formData.append("file", obj.files.item(0));
            formData.append("fileType", FileType.FileImage);
            formData.append("isMessageAttachment",true);
            var src = window.URL.createObjectURL(obj.files.item(0));
            getMsgImageSize(src);
            uploadMsgImgToServer(formData, src, uploadImgForMsg);

            return window.URL.createObjectURL(obj.files.item(0));
        }
        return obj.value;
    }
}

function uploadMsgImgFromCopy(image)
{
    var base64ImageContent = image.replace(/^data:image\/(png|jpg);base64,/, "");
    var blob = base64ToBlob(base64ImageContent, 'image/png');
    var formData = new FormData();

    formData.append("file", blob);
    formData.append("fileType", FileType.FileImage);
    formData.append("isMessageAttachment",true);
    var src = window.URL.createObjectURL(blob);
    getMsgImageSize(src);
    uploadMsgImgToServer(formData, src, uploadImgForMsg);
}

function getMsgImageSize(src)
{
    var image = new Image();
    image.src = src;
    image.onload = function (ev) {
        msgImageSize = {
            width:image.width,
            height:image.height
        }
        console.log("msgImageSize==" + JSON.stringify(msgImageSize));
    };
}

function autoMsgImgSize(imgObject, h, w)
{
    var image = new Image();
    image.src = imgObject.src;
    var imageNaturalWidth  = image.naturalWidth;
    var imageNaturalHeight = image.naturalHeight;

    if (imageNaturalWidth < w && imageNaturalHeight<h) {
        imgObject.width  = imageNaturalWidth == 0 ? w : imageNaturalWidth;
        imgObject.height = imageNaturalHeight == 0 ? h : imageNaturalHeight;
    } else {
        if (w / h <= imageNaturalWidth/ imageNaturalHeight) {
            imgObject.width  = w;
            imgObject.height = w* (imageNaturalHeight / imageNaturalWidth);
        } else {
            imgObject.width  = h * (imageNaturalWidth / imageNaturalHeight);
            imgObject.height = h;
        }
    }
}

function getMsgSize(imageNaturalWidth,imageNaturalHeight, h, w)
{
    var imgObject = {};
    if (imageNaturalWidth < w && imageNaturalHeight<h) {
        imgObject.width  = imageNaturalWidth == 0 ? w : imageNaturalWidth;
        imgObject.height = imageNaturalHeight == 0 ? h : imageNaturalHeight;
    } else {
        if (w / h <= imageNaturalWidth/ imageNaturalHeight) {
            imgObject.width  = w;
            imgObject.height = w* (imageNaturalHeight / imageNaturalWidth);
        } else {
            imgObject.width  = h * (imageNaturalWidth / imageNaturalHeight);
            imgObject.height = h;
        }
    }
    imgObject = {
        width:imgObject.width + "px",
        height:imgObject.height + "px",
    };
    return imgObject;
}


function base64ToBlob(base64, mime)
{
    mime = mime || '';
    var sliceSize = 1024;
    var byteChars = window.atob(base64);
    var byteArrays = [];

    for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
        var endOffset = (offset+sliceSize);
        if(endOffset > byteChars.length) {
            endOffset = byteChars.length;
        }

        var slice = byteChars.slice(offset, endOffset);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    return new Blob(byteArrays, {type: mime});
}


function uploadMsgImgToServer(formData, src, type)
{
    var chatSessionId = localStorage.getItem(chatSessionIdKey);
    var chatSessionType = localStorage.getItem(chatSessionId);

    $.ajax({
        url:"./index.php?action=http.file.uploadWeb",
        type:"post",
        data:formData,
        contentType:false,
        processData:false,
        success:function(fileName){
            console.log("file upload " + fileName);
            if(fileName) {
                if(fileName == "failed") {
                    alert("发送失败,稍后重试");
                    return false;
                }
                if(type == uploadImgForMsg) {
                    // alert("上传成功！");
                    var imgKey = sendMsgImgUrlKey+fileName;
                    localStorage.setItem(imgKey, src);

                    sendMsg(chatSessionId, chatSessionType, fileName, MessageType.MessageImage);
                    $("#msgImage").html("");
                    $("#msgImage")[0].style.display = "none";
                } else if(type == uploadImgForSelfAvatar) {
                    updateUserAvatar(fileName);
                }
            }
        },
        error:function(err){
            console.log("file upload " + fileName);
            alert("发送失败,稍后重试");
            return false;
        }
    });
}

function uploadUserImgFromInput(obj) {
    if (obj) {
        if (obj.files) {
            formData = new FormData();

            formData.append("file", obj.files.item(0));
            formData.append("fileType", FileType.FileImage);
            formData.append("isMessageAttachment", false);

            var src = window.URL.createObjectURL(obj.files.item(0));
            getMsgImageSize(src);

            uploadMsgImgToServer(formData, src, uploadImgForSelfAvatar);

            $(".user-image-upload").attr("src", src);
        }
        return obj.value;
    }
}

function updateUserAvatar(fileName)
{
    var values = new Array();
    var value = {
        type : "ApiUserUpdateAvatar",
        avatar : fileName,
    };
    values.push(value);
    updateUserInfo(values);
}


