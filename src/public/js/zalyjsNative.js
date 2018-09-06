var clientType = "iOS"
// var callbackIdParamName = "_zalyjsCallbackId"
var callbackIdParamName = "zalyjsCallbackId"

var zalyjsCallbackHelper = function() {
    var thiz = this
    this.dict = {}

    //
    // var id = helper.register(callback)
    //
    this.register = function(callback) {
        var id = Math.random().toString()
        thiz.dict[id] = callback
        return id
    }

    //
    // helper.call({"_zalyjsCallbackId", "args": ["", "", "", ....]  })
    //
    this.callback = function(param) {
        try {
            param = atob(param);
            // js json for \n
            param = param.replace(/\n/g,"\\\\n");

            var paramObj = JSON.parse(param)
            var id = paramObj[callbackIdParamName]

            var args = paramObj["args"]
            var callback = thiz.dict["" + id]
            if (callback != undefined) {
                // callback.apply(undefined, args)
                callback(args);
                delete(thiz.dict[id])
            } else {
                // do log
            }
        } catch (error) {
            // do log
        }
    }
    return this
}();

getOsType();

function getOsType() {
    var u = navigator.userAgent;
    if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {
        clientType =  'Android';
    } else if (u.indexOf('iPhone') > -1) {
        clientType = 'IOS';
    } else {
        clientType = "";
    }
}

function isAndroid() {
    return clientType.toLowerCase() == "android"
}

function isIOS() {
    return clientType.toLowerCase() == "ios"
}

function jsonToQueryString(json) {
    url = Object.keys(json).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(json[k])
    }).join('&')
    return url
}


//
//
// Javascript Bridge Begin
//
//

function zalyjsSetClientType(t) {
    clientType = t
}

function zalyjsNavOpenPage(url) {
    var messageBody = {}
    messageBody["url"] = url
    messageBody = JSON.stringify(messageBody)

    if (isAndroid()) {
        window.Android.zalyjsNavOpenPage(messageBody)
    } else if(isIOS()) {
        window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
    }
}

function zalyjsLoginSuccess(loginName, sessionid, isRegister, callback) {

    var callbackId = zalyjsCallbackHelper.register(callback)
    var messageBody = {}
    messageBody["loginName"] = loginName
    messageBody["sessionid"] = sessionid
    messageBody["isRegister"] = (isRegister == true ? true : false)
    messageBody[callbackIdParamName] = callbackId
    messageBody = JSON.stringify(messageBody)

    if (isAndroid()) {
        window.Android.zalyjsLoginSuccess(messageBody)
    } else if(isIOS()) {
        window.webkit.messageHandlers.zalyjsLoginSuccess.postMessage(messageBody)
    }
}

function zalyjsLoginConfig(callback) {
    var callbackId = zalyjsCallbackHelper.register(callback)

    var messageBody = {}
    messageBody[callbackIdParamName] = callbackId
    messageBody = JSON.stringify(messageBody)

    if (isAndroid()) {
        window.Android.zalyjsLoginConfig(messageBody)
    } else if(isIOS()) {
        window.webkit.messageHandlers.zalyjsLoginConfig.postMessage(messageBody)
    }
}

function zalyjsNavClosePlugin()
{
    if (isAndroid()) {
        window.Android.zalyjsNavClosePlugin()
    } else if(isIOS()) {
        window.webkit.messageHandlers.zalyjsNavClosePlugin()
    }
}



function zalyjsAlert(str)
{
    if (isAndroid()) {
        window.Android.zalyjsAlert(str)
    } else if(isIOS()) {
    } else {
        alert(str);
    }
}
