<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../../public/css/login.css">
    <script type="text/javascript" src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/jquery.i18n.properties.min.js"></script>
    <script type="text/javascript" src="../../public/js/login/callback.js"></script>
    <script src="../../public/js/zalyjsNative.js"></script>
    <script src="../../public/js/template-web.js"></script>

</head>
<body>

<div class="zaly_container" >
    <div class="zaly_login zaly_login_by_pwd" >
        <div class="login_input_div" >
            <div class="d-flex flex-row justify-content-center margin-top5 login-header" style="text-align: center;">
                <span class="login_phone_tip_font" data-local-value="loginTip">Login</span>
            </div>

            <div class=" d-flex flex-row justify-content-left login_name_div" >
                <image src="../../public/img/login/loginName.png" class="img"/>
                <input type="text" class="input_login_site  login_input_loginName"  data-local-placeholder="loginNamePlaceholder" placeholder="Please Enter LoginName" >
                <div class="clearLoginName" onclick="clearLoginName()"><image src="../../public/img/msg/btn-x.png" class="clearLoginName" style="width: 2rem;height:2rem;"/></div>
                <div class="line"></div>
            </div>

            <div class="login_name_div" style="margin-top: 1rem;">
                <image src="../../public/img/login/pwd.png" class="img"/>
                <input type="password" class="input_login_site phone_num  login_input_pwd" data-local-placeholder="enterPasswordPlaceholder"  placeholder="Please Enter Password" >
                <div class="pwd_div" onclick="changeImgByClickPwd()"><image src="../../public/img/login/hide_pwd.png" class="pwd" img_type="hide" /></div>
                <div class="line"></div>
            </div>

            <div class="d-flex flex-row justify-content-center ">
                <button type="button" class="btn login_button" ><span class="span_btn_tip" data-local-value="loginTip">Login</span></button>
            </div>

            <div class="d-flex flex-row register_span_div" >
                <span onclick="registerForPassportPassword()" data-local-value="registerTip">Register</span>
                <span onclick="forgetPwdForPassportPassword()" data-local-value="forgetPasswordTip">Forget Password</span>
            </div>

        </div>
    </div>
    <div class="zaly_login zaly_site_register zaly_site_register-pwd" style="display: none;">

    </div>
    <div class="zaly_login zaly_site_register zaly_site_register-repwd" style="display: none;">
        <div class="back">
            <img src="../../public/img/back.png" style="margin-left: 2rem; width: 4rem;height:4rem; margin-top: 2rem;" onclick="returnLoginPage(); return false;"/>
        </div>
        <div class="login_input_div" >
            <div class="d-flex flex-row justify-content-center login-header" style="text-align: center;margin-top: 8rem;">
                <span class="login_phone_tip_font"  data-local-value="findPasswordTip">Find Password</span>
            </div>

            <div class="login_name_div">
                <image src="../../public/img/login/loginName.png" class="img"/>
                <input type="text" class="input_login_site forget_input_loginName" data-local-placeholder="loginNamePlaceholder" placeholder="Please Enter LoginName">
                <div class="line"></div>
            </div>

            <div class=" d-flex flex-row justify-content-left login_name_div"  style="margin-top: 1rem;">
                <image src="../../public/img/login/code.png" class="img"/>
                <input type="text"  value="" class="input_login_site  forget_input_code" data-local-placeholder="enterVerifyCodePlaceholder"  placeholder="Please Enter Verify Code"  >
                <span class="get_verify_code" onclick="getVerifyCode()" data-local-value="getVerifyCodeTip" >Get Verify Code</span>
                <div class="line"></div>
            </div>

            <div class="login_name_div forget_input_pwd_div" style="margin-top: 1rem;display:none;" >
                <image src="../../public/img/login/pwd.png" class="img"/>
                <input type="password" class="input_login_site forget_input_pwd"  data-local-placeholder="enterPasswordPlaceholder"  placeholder="Please Enter Password" >
                <div class="pwd_div" onclick="changeImgByClickPwd()"><image src="../../public/img/login/hide_pwd.png" class="pwd" img_type="hide"/></div>
                <div class="line"></div>
            </div>

            <div class="login_name_div forget_input_repwd_div" style="margin-top: 1rem; display:none;">
                <image src="../../public/img/login/re_pwd.png" class="img"/>
                <input type="password" class="input_login_site forget_input_repwd"  data-local-placeholder="enterRepasswordPlaceholder"  placeholder="Please Enter Password Again"  >
                <div class="repwd_div" onclick="changeImgByClickRepwd()"><image src="../../public/img/login/hide_pwd.png" class="pwd" img_type="hide"/></div>
                <div class="line" ></div>
            </div>

            <div class="d-flex flex-row justify-content-center ">
                <button type="button" class="btn reset_pwd_button"><span class="span_btn_tip" data-local-value="resetPwdTip">Reset Password</span></button>
            </div>
        </div>
    </div>

    <div class="zaly_login zaly_site_register zaly_site_register-invitecode" style="display: none;">
        <div class="back">
            <img src="../../public/img/back.png" style="margin-left: 2rem; width: 4rem;height:4rem; margin-top: 2rem;" onclick="returnRegisterDiv(); return false;"/>
        </div>
        <div class="login_input_div" >
            <div class="d-flex flex-row justify-content-center login-header"style="text-align: center;margin-top: 8rem;margin-bottom: 1rem;">
                <span class="login_phone_tip_font" data-local-value="registerInvitationCodeTip" >输入邀请码</span>
            </div>

            <div class="code_div" style="margin-top: 8rem;">
                <input type="text" class="input_login_site register_input_code" style="margin-left: 0rem;" data-local-placeholder="enterCodePlaceholder"  placeholder="Please Enter Code"  >
                <div class="line" ></div>
            </div>

            <div class="d-flex flex-row justify-content-center " >
                <button type="button" class="btn register_button" style="margin-top: 7rem;"><span class="span_btn_tip" data-local-value="registerBtnTip">Register</span></button>
            </div>

        </div>
    </div>
</div>
<?php include(dirname(__DIR__) . '/login/template_login.php'); ?>

<script src="../../public/js/im/zalyKey.js"></script>
<script src="../../public/js/im/zalyAction.js"></script>
<script src="../../public/js/im/zalyClient.js"></script>
<script src="../../public/js/im/zalyBaseWs.js"></script>

<script type="text/javascript">


    var languageName = navigator.language == "en-US" ? "en" : "zh";

    var languageName = "zh";
    jQuery.i18n.properties({
        name: "lang",
        path: '../../public/js/config/',
        mode: 'map',
        language: languageName,
        callback: function () {
            try {
                //初始化页面元素
                $('[data-local]').each(function () {
                    var changeData = $(this).attr("data-local");
                    var changeDatas = changeData.split(":");
                    var changeDataName = changeDatas[0];
                    var changeDataValue = changeDatas[1];
                    $(this).attr(changeDataName, $.i18n.map[changeDataValue]);
                });
                $('[data-local-value]').each(function () {
                    var changeHtmlValue = $(this).attr("data-local-value");
                    $(this).html($.i18n.map[changeHtmlValue]);
                });
                $('[data-local-placeholder]').each(function () {
                    var placeholderValue = $(this).attr("data-local-placeholder");
                    $(this).attr("placeholder", $.i18n.map[placeholderValue]);
                });
            }
            catch(ex){
                console.log(ex.message);
            }
        }
    });

    refererUrl = document.referrer;
    secondNum  = 120;
    isSending  = false;

    var protocol = window.location.protocol;
    var host = window.location.host;
    var pathname = window.location.pathname;
    originDomain = protocol+"//"+host+pathname;

    if(refererUrl != undefined && refererUrl.length>1) {
        siteConfigJsUrl = "./index.php?action=page.siteConfig&callback=zalyLoginConfig";
        addJsByDynamic(siteConfigJsUrl);
    } else {
        zalyjsLoginConfig(zalyLoginConfig);
    }

    function addJsByDynamic(url)
    {
        console.log(url);
        var script = document.createElement("script")
        script.type = "text/javascript";
        //Firefox, Opera, Chrome, Safari 3+
        script.src = url;
        $(".zaly_container")[0].appendChild(script);
    }

    function changeImgByClickPwd() {
        var imgType = $(".pwd").attr("img_type");
        if(imgType == "hide") {
            $(".pwd").attr("img_type", "display");
            $(".pwd").attr("src", "../../public/img/login/display_pwd.png");
            $(".login_input_pwd").attr("type", "text");
            $(".register_input_pwd").attr("type", "text");
            $(".forget_input_pwd").attr("type", "text");
        } else {
            $(".pwd").attr("img_type", "hide");
            $(".pwd").attr("src", "../../public/img/login/hide_pwd.png");
            $(".login_input_pwd").attr("type", "password");
            $(".register_input_pwd").attr("type", "password");
            $(".forget_input_pwd").attr("type", "password");
        }
    }

    function changeImgByClickRepwd() {
        var imgType = $(".repwd").attr("img_type");
        if(imgType == "hide") {
            $(".repwd").attr("img_type", "display");
            $(".repwd").attr("src", "../../public/img/login/display_pwd.png");
            $(".register_input_repwd").attr("type", "text");
            $(".forget_input_repwd").attr("type", "text");
        } else {
            $(".repwd").attr("img_type", "hide");
            $(".repwd").attr("src", "../../public/img/login/hide_pwd.png");
            $(".register_input_repwd").attr("type", "password");
            $(".forget_input_repwd").attr("type", "password");
        }
    }

    $(".input_login_site").bind('input porpertychange',function(){
        if($(this).val().length>0) {
            $(this).addClass("black");
            $(this).removeClass("outline");
        }
    });

    $(".login_input_loginName").bind('input porpertychange',function(){
        if($(".login_input_loginName").val().length>0) {
            $(".login_input_loginName").addClass("black");
        }
        enableLoginSiteBtn();
    });

    $(".login_input_pwd").bind('input porpertychange',function(){
        if($(".login_input_pwd").val().length>0) {
            $(".login_input_pwd").addClass("black");
        }
        enableLoginSiteBtn();
    });

    function enableLoginSiteBtn()
    {
        if($(".login_input_pwd").val().length>0 && $(".login_input_loginName").val().length>0) {
            $(".login_button").attr("disabled", false);
            $(".login_button").addClass("btn-enable-color");
        } else {
            $(".login_button").attr("disabled", true);
            $(".login_button").removeClass("btn-enable-color");
        }
    }

    function registerForPassportPassword()
    {
        // $(".input_login_site").val("")/**/;
        var html = template("tpl-login-div", {
            enableInvitationCode : enableInvitationCode
        });
        html = handleHtmlLanguage(html);
        $(".zaly_site_register-pwd").html(html);
        $(".zaly_login_by_pwd")[0].style.display = "none";
        $(".zaly_site_register-pwd")[0].style.display = "block";
    }

    function returnRegisterDiv() {
        $(".zaly_site_register-pwd")[0].style.display = "block";
        $(".zaly_site_register-invitecode")[0].style.display = "none";
    }

    function handleHtmlLanguage(html)
    {

        $(html).find("[data-local-placeholder]").each(function () {
            var placeholderValue = $(this).attr("data-local-placeholder");
            var placeholder = $(this).attr("placeholder");
            var newPlaceholder = $.i18n.map[placeholderValue];
            html = html.replace(placeholder, newPlaceholder);
        });

        $(html).find("[data-local-value]").each(function () {
            var changeHtmlValue = $(this).attr("data-local-value");
            var valueHtml = $(this).html();

            var newValueHtml = $.i18n.map[changeHtmlValue];

            html = html.replace(valueHtml, newValueHtml);
        });


        return html;
    }


    function forgetPwdForPassportPassword()
    {
        $(".zaly_login_by_pwd")[0].style.display = "none";
        $(".zaly_site_register-repwd")[0].style.display = "block";
    }

    function registerForLogin()
    {
        // $(".input_login_site").val("");
        $(".zaly_login_by_pwd")[0].style.display = "block";
        $(".zaly_site_register-pwd")[0].style.display = "none";
    }

    $(document).on("click", ".register_code_button", function () {
        var flag = checkRegisterInfo();
        if(flag == false) {
            return false;
        }
        $(".zaly_site_register-invitecode")[0].style.display = "block";
        $(".zaly_site_register-pwd")[0].style.display = "none";
    });

    function checkRegisterInfo()
    {
        registerLoginName = $(".register_input_loginName").val();
        registernNickname  = $(".register_input_nickname").val();
        registerPassword  = $(".register_input_pwd").val();
        repassword = $(".register_input_repwd").val();
        registerEmail = $(".register_input_email").val();
        isFocus = false;

        if(registerLoginName == "" || registerLoginName == undefined || registerLoginName.length<0 ) {
            $("#register_input_loginName").focus();
            $("#register_input_loginName").addClass("outline");
            isFocus = true;
        }

        if(!isLoginName(registerLoginName) || registerLoginName.length>16) {
            $("#register_input_loginName").focus();
            $("#register_input_loginName").addClass("outline");
            isFocus = true;
        }

        if(registernNickname == "" || registernNickname == undefined || registernNickname.length<0 || registernNickname.length>16) {
            $("#register_input_nickname").addClass("outline");
            if(isFocus == false) {
                $("#register_input_nickname").focus();
                isFocus = true;
            }
        }

        if(registerPassword == "" || registerPassword == undefined || registerPassword.length<0) {
            $("#register_input_pwd").addClass("outline");
            if (isFocus == false) {
                $("#register_input_pwd").focus();
                isFocus = true;
            }
        }

        if(repassword == "" || repassword == undefined || repassword.length<0) {
            $("#register_input_repwd").addClass("outline");
            if(isFocus == false) {
                $("#register_input_repwd").focus();
                isFocus = true;
            }
        }

        if(registerEmail == "" || registerEmail == undefined || registerEmail.length<0) {
            $("#register_input_email").addClass("outline");
            if(isFocus == false) {
                $("#register_input_email").focus();
                isFocus = true;
            }
        }


        if(isFocus == true) {
            return false;
        }

        if(registerPassword != repassword) {
            alert($.i18n.map["passwordIsNotSameJsTip"]);
            return false;
        }
        if(!validateEmail(registerEmail)) {
            alert($.i18n.map["emailJsTip"]);
            return false;
        }
        return true;
    }

    /**
     * 数字 字母下划线
     * @param loginName
     */
    function isLoginName(loginName)
    {
        var reg = /^[A-Za-z0-9_]+$/;
        return reg.test(loginName);
    }


    $(document).on("click", ".register_button", function () {
        checkRegisterInfo();
        invitationCode = $(".register_input_code").val();
        var jsUrl = "./index.php?action=page.js&loginName="+registerLoginName+"&success_callback=loginNameExist&fail_callback=loginNameNotExist";
        addJsByDynamic(jsUrl);
    });


    function handlePassportPasswordReg(results)
    {
        var preSessionId = results.preSessionId;
        if(refererUrl != undefined && refererUrl.length>1) {
            handleRedirect(preSessionId, 1);
        } else {
            zalyjsLoginSuccess(registerLoginName, preSessionId, true, loginFailed);
        }
    }

    function validateEmail(email)
    {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    $(document).on("click", ".login_button", function () {

        loginName = $(".login_input_loginName").val();
        loginPassword  = $(".login_input_pwd").val();
        var isFocus = false;
        if(loginName == "" || loginName == undefined || loginName.length<0) {
            $(".login_input_loginName").focus();
            $(".login_input_loginName").addClass("outline");
            isFocus = true;
        }
        if(loginPassword == "" || loginPassword == undefined || loginPassword.length<0) {
            $(".login_input_pwd").addClass("outline");
            if (isFocus == false) {
                $(".login_input_pwd").focus();
                isFocus = true;
            }
        }

        if(isFocus == true ) {
            return false;
        }

        var action = "api.passport.passwordLogin";
        var reqData = {
            loginName:loginName,
            password:loginPassword,
            sitePubkPem:sitePubkPem,
        };
        handleClientSendRequest(action, reqData, handleApiPassportPasswordLogin);
    });

    function handleApiPassportPasswordLogin(results)
    {
        var preSessionId = results.preSessionId;
        if(refererUrl != undefined && refererUrl.length>1) {
            handleRedirect(preSessionId, 0);
        } else {
            zalyjsLoginSuccess(loginName, preSessionId, false, loginFailed);
        }
    }

    function loginFailed(results)
    {
        console.log(results);
    }

    function getVerifyCode()
    {
        if(isSending == true) {
            return;
        }
        var loginName = $(".forget_input_loginName").val();
        if(loginName.length < 1) {
            ////TODO 换成 页面漂浮报错
            alert($.i18n.map["loginNameNotNullJsTip"]);
            return false;
        }

        var action = "api.passport.passwordFindPassword";
        var reqData = {
            "loginName" : loginName,
        };

        handleClientSendRequest(action, reqData, handleVerifyCode);
    }

    function handleVerifyCode()
    {
        isSending = true;
        showTime();
        $(".get_verify_code").attr("disabled", true);
        $(".get_verify_code").addClass("btn-disable-color");
        $(".forget_input_repwd_div")[0].style.display = "block";
        $(".forget_input_pwd_div")[0].style.display = "block";
    }

    function showTime()
    {
        secondNum = secondNum-1;
        if(secondNum < 0) {
            var html = "获取验证码";
            $(".get_verify_code").html(html);
            $(".get_verify_code").attr("disabled", false);
            $(".get_verify_code").removeClass("btn-disable-color");
            isSending = false;
            return false;
        }
        var html  = secondNum+$.i18n.map['sendVerifyCodeTimeJsTip']
        $(".get_verify_code").html(html);
        setTimeout(function () {
            showTime();
        },1000);
    }

    $(document).on("click", ".reset_pwd_button", function () {
        var action = "api.passport.passwordResetPassword";
        var isFocus = false;
        var token = $(".forget_input_code").val();
        var repassword = $(".forget_input_repwd").val();
        var password = $(".forget_input_pwd").val();
        var loginName = $(".forget_input_loginName").val();

        if(repassword != password) {
            alert($.i18n.map["passwordIsNotSameJsTip"]);
            return;
        }
        if(loginName == "" || loginName == undefined || loginName.length<0) {
            $(".login_input_loginName").focus();
            $(".login_input_loginName").addClass("outline");
            isFocus = true;
        }

        if(password.length<0 || repassword.length<0) {
            isFocus = true;
        }
        if(isFocus == true) {
            return;
        }
        var reqData = {
            "loginName" : loginName,
            "token" :token,
            "password" :password
        };

        handleClientSendRequest(action, reqData, handleResetPwd);
    });

    function handleResetPwd()
    {
        $(".zaly_login_by_pwd")[0].style.display = "block";
        $(".zaly_site_register-pwd")[0].style.display = "none";
        $(".zaly_site_register-repwd")[0].style.display = "none";
    }

    function returnLoginPage()
    {
        window.location.reload();
    }

    function clearLoginName()
    {
        $(".login_input_loginName").val("");
    }

</script>
</body>
</html>
