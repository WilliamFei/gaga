
wsImObj = "";
wsUrl = localStorage.getItem(websocketGWUrl);

enableWebsocketGw = localStorage.getItem(websocketGW);

function websocketIm(transportDataJson, callback)
{
    ////TODO gateway 地址需要传入

    if(wsImObj == '' || wsImObj.readyState == WS_CLOSED || wsImObj.readyState == WS_CLOSING) {
        wsImObj = new WebSocket(wsUrl);
    }

    if(wsImObj.readyState == WS_OPEN) {
        wsImObj.send(transportDataJson);
    }

    wsImObj.onopen = function(evt) {
        //TODO auth
        wsImObj.send(transportDataJson);
    };

    wsImObj.onmessage = function(evt) {
        var resp = evt.data;
        handleReceivedImMessage(resp, callback);
    };

    wsImObj.onclose = function(evt) {
        reConnectWs()
    };
    wsImObj.onerror = function (evt) {
        reConnectWs()
    };
}

function createWsConnect()
{
    if(wsImObj == '' || wsImObj.readyState == WS_CLOSED || wsImObj.readyState == WS_CLOSING) {
        wsImObj = new WebSocket(wsUrl);
    }
}

function reConnectWs()
{
    if(lockReconnect == true) return;
    lockReconnect = true;
    setTimeout(function () {
        createWsConnect();
        lockReconnect = false;
    }, 1000);
}

function handleImSendRequest(action, reqData, callback)
{
    try {
        var requestName = ZalyAction.getReqeustName(action);
        var requestUrl  = ZalyAction.getRequestUrl(action);

        var body = {};
        body["@type"] = "type.googleapis.com/"+requestName;
        for(var key in reqData) {
            body[key] = reqData[key];
        }

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

        var transportDataJson = JSON.stringify(transportData);
        var enableWebsocketGw = localStorage.getItem(websocketGW);
        if(enableWebsocketGw == "true" && wsUrl != null && wsUrl) {
            websocketIm(transportDataJson, callback);
        } else {
            $.ajax({
                method: "POST",
                url:requestUrl,
                // dataType:"json",
                data: transportDataJson,
                success:function (resp, status, request) {
                    // console.log("status ==" + status);
                    var debugInfo = request.getResponseHeader('duckchat-debugInfo');
                    if(debugInfo != null) {
                        console.log("debug-info ==" + debugInfo);
                    }
                    if(resp) {
                        handleReceivedImMessage(resp, callback);
                    }
                }
            });
        }
    } catch(e) {
        return false;
    }
}


function handleReceivedImMessage(resp, callback)
{
    var result = JSON.parse(resp);
    if(result.action == ZalyAction.im_stc_news) {
        syncMsgForRoom();
        return;
    }

    if(result.header != undefined && result.header.hasOwnProperty(HeaderErrorCode)) {
        if(result.header[HeaderErrorCode] != "success") {
            if(result.header[HeaderErrorCode] == ErrorSessionCode ) {
                wsImObj.close();
                localStorage.clear();
                window.location.href = "./index.php?action=page.logout";
                return;
            }
            alert(result.header[HeaderErrorInfo]);
            return;
        }
    }

    if(result.action == ZalyAction.im_stc_message_key) {
        handleSyncMsgForRoom(result.body);
        return;
    }

    if(callback instanceof Function && callback != undefined) {
        callback(result.body);
        return;
    }

}

