
wsClientObj = "";
wsUrl = localStorage.getItem(websocketGWUrl);

var wsClientObjStore = [];

function websocketClient(transportDataJson, callback)
{
    ////TODO gateway 地址需要传入

    wsClientObj = new WebSocket(wsUrl);

    wsClientObj.onopen = function(evt) {
        //TODO auth
        if(wsClientObj.readyState == WS_OPEN) {
            wsClientObj.send(transportDataJson);
        }
    };

    wsClientObj.onmessage = function(evt) {
        var resp = evt.data;
        handleClientReceivedMessage(resp, callback);
        ////默认client都是短链接，用完就关掉，
        wsClientObj.close();
    };

    wsClientObj.onclose = function(evt) {
        shiftWsQueue();
    };
}

function handleClientSendRequest(action, reqData, callback, isHttp)
{
    try {
        var requestName = ZalyAction.getReqeustName(action);
        var requestUrl  = ZalyAction.getRequestUrl(action);

        var body = {};
        body["@type"] = "type.googleapis.com/"+requestName;
        for(var key in reqData) {
            body[key] = reqData[key];
        }

        var sessionId = $(".session_id").attr("data");
        var header = {};
        header[HeaderSessionid] = sessionId;
        header[HeaderHostUrl] = originDomain;
        header[HeaderUserClientLang] = languageName = navigator.language == "en-US" ? "0" : "1";

        var packageId = localStorage.getItem(PACKAGE_ID);

        var transportData = {
            "action" : action,
            "body": body,
            "header" : header,
            "packageId" : Number(packageId),
        };

        var packageId = localStorage.setItem(PACKAGE_ID, (Number(packageId)+1));

        this.callback = callback;
        var transportDataJson = JSON.stringify(transportData);

        var enableWebsocketGW = localStorage.getItem(websocketGW);
        if(enableWebsocketGW == "true" && !isHttp  && wsUrl != null && wsUrl) {
            putWsQueue(transportDataJson, callback);
            if(wsClientObjStore.length == 1 && (wsClientObj.readyState == undefined || wsClientObj.readyState == WS_CLOSING || wsClientObj.readyState == WS_CLOSED)) {
                shiftWsQueue();
            }
        } else {
            $.ajax({
                method: "POST",
                url:requestUrl,
                data: transportDataJson,
                success:function (resp, status, request) {
                    var debugInfo = request.getResponseHeader('duckchat-debugInfo');
                    if(debugInfo != null) {
                        console.log("debug-info ==" + debugInfo);
                    }
                    handleClientReceivedMessage(resp, callback);
                }
            });
        }
    } catch(e) {
        return false;
    }
}

function putWsQueue(transportDataJson, callback)
{
    var queueData = {
        transportDataJson:transportDataJson,
        callback:callback
    };
    wsClientObjStore.push(queueData);
}

function shiftWsQueue()
{
    var queueData = wsClientObjStore.shift();
    if(queueData == undefined) {
        return ;
    }
    var transportDataJson = queueData.transportDataJson;
    var callback = queueData.callback;
    websocketClient(transportDataJson, callback);
}

function handleClientReceivedMessage(resp, callback)
{
    var result = JSON.parse(resp);
    if(result.header != undefined && result.header.hasOwnProperty(HeaderErrorCode)) {
        if(result.header[HeaderErrorCode] != "success") {
            if(result.header[HeaderErrorCode] == ErrorSessionCode ) {
                localStorage.clear();
                window.location.href = "./index.php?action=page.logout";
                return ;
            }
            if(result.action == "api.friend.profile") {
                callback(result.body);
            } else {
                alert(result.header[HeaderErrorInfo]);
                return;
            }
        }
    }
    if(callback instanceof Function && callback != undefined) {
        callback(result.body);
    }
}
