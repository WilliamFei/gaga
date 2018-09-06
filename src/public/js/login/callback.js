
refererKey = "site_referer";
siteConfig = {};
enableInvitationCode=0;
enableRealName=0;
sitePubkPem="";
invitationCode='';
nickname="";
allowShareRealname=0;
preSessionId="";

refererUrl = document.referrer;

function zalyLoginConfig(results) {
    if(typeof results == "object" ) {
        siteConfig = results;
    } else {
        siteConfig = JSON.parse(results);
    }
    enableInvitationCode = siteConfig.enableInvitationCode;
    enableRealName=siteConfig.enableRealName;
    sitePubkPem = siteConfig.sitePubkPem;
}

function loginSuccess()
{
    handleRedirect(preSessionId);
}

function loginFailNeedRegister()
{
    registerSite();
}


function handleRedirect(preSessionId, isRegister)
{
    if(refererUrl) {
        if(refererUrl.indexOf("?") > -1) {
            refererUrl = refererUrl+"&preSessionId="+preSessionId+"&isRegister="+isRegister;
        } else {
            refererUrl = refererUrl+"?preSessionId="+preSessionId+"&isRegister="+isRegister;
        }
        window.location.href = refererUrl;
    }
}

function loginNameExist()
{
    alert("用户名已经在站点被注册");
}

function loginNameNotExist()
{
    var action = "api.passport.passwordReg";
    var reqData = {
        loginName:registerLoginName,
        password:registerPassword,
        email:registerEmail,
        nickname:registernNickname,
        sitePubkPem:sitePubkPem,
        invitationCode:invitationCode,
    }
    // alert("Json=="+JSON.stringify(reqData));
    handleClientSendRequest(action, reqData, handlePassportPasswordReg);
}