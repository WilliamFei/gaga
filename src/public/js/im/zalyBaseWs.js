
wsObj = "";
landingPageUrl="";
var config  = localStorage.getItem(siteConfigKey);
var enableWebsocketGw = localStorage.getItem(websocketGW);

wsUrlSuffix = "?body_format=json";

var packageId = localStorage.getItem(PACKAGE_ID);

if(packageId == null) {
    localStorage.setItem(PACKAGE_ID, 1);
}

var protocol = window.location.protocol;
var host = window.location.host;
var pathname = window.location.pathname;
originDomain = protocol+"//"+host+pathname;


function ZalyIm(params)
{
    var config = params.config;
    var loginPluginProfile = params.loginPluginProfile;
    var webSocketGwDomain = config[siteConfigKeys.serverAddressForIM];
    if(webSocketGwDomain == undefined || webSocketGwDomain == null || webSocketGwDomain.length<1 || webSocketGwDomain.indexOf("http://") > -1) {
        localStorage.setItem(websocketGW, "false");////是否开启    console.log("webSocketGwDomain ==" + webSocketGwDomain);
    } else {
        var webSocketGw = webSocketGwDomain + wsUrlSuffix;
        if(webSocketGwDomain.length > 1) {
            localStorage.setItem(websocketGW, "true");////是否开启
            localStorage.setItem(websocketGWUrl, webSocketGw);
        }
    }
    localStorage.setItem(siteConfigKey, JSON.stringify(config));
    localStorage.setItem(siteLoginPluginKey, JSON.stringify(loginPluginProfile))
    landingPageUrl = loginPluginProfile.landingPageUrl;
}

function requestSiteConfig(callback)
{
    var action  = "api.site.config";
    var reqData = {};
    handleClientSendRequest(action, reqData, callback, true);
}
