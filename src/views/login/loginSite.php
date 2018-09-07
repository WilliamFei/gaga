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
<script src="../../public/js/login/login.js"></script>

</body>
</html>
