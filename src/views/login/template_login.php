
<script id="tpl-login-div" type="text/html">

    <div class="login_input_div" >
        <div class="d-flex flex-row justify-content-center login-header"style="text-align: center;margin-top: 2rem;margin-bottom: 1rem;">
            <span class="login_phone_tip_font" data-local-value="registerTip" >Register</span>
        </div>

        <div class="d-flex flex-row justify-content-left login_name_div" >
            <image src="../../public/img/login/loginName.png" class="img"/>
            <input type="text" id="register_input_loginName"  class="input_login_site  register_input_loginName" data-local-placeholder="registerLoginNamePlaceholder"   placeholder="用户名以字母、数字、下划线，1-16个字符" >
            <div class="line"></div>
        </div>

        <div class="login_name_div" style="margin-top: 1rem;">
            <image src="../../public/img/login/pwd.png" class="img"/>
            <input type="password" class="input_login_site register_input_pwd"  id="register_input_pwd" data-local-placeholder="enterPasswordPlaceholder"  placeholder="Please Enter Password"  >
            <div class="pwd_div" onclick="changeImgByClickPwd()"><image src="../../public/img/login/hide_pwd.png" class="pwd" img_type="hide"/></div>
            <div class="line"></div>
        </div>

        <div class="login_name_div" style="margin-top: 1rem;">
            <image src="../../public/img/login/pwd.png" class="img"/>
            <input type="password" class="input_login_site register_input_repwd"  id="register_input_repwd" data-local-placeholder="enterRepasswordPlaceholder"  placeholder="Please Enter Password Again"  >
            <div class="repwd_div" onclick="changeImgByClickRepwd()"><image src="../../public/img/login/hide_pwd.png" class="repwd" img_type="hide"/></div>
            <div class="line" ></div>
        </div>

        <div class="login_name_div" style="margin-top: 1rem;">
            <image src="../../public/img/login/nickname.png" class="img"/>
            <input type="text" class="input_login_site register_input_nickname"   id="register_input_nickname" data-local-placeholder="enterNicknamePlaceholder" placeholder="Please Enter Nickname"  >
            <div class="line"></div>
        </div>

        <div class="login_name_div" style="margin-top: 1rem;">
            <image src="../../public/img/login/email.png" class="img"/>
            <input type="text" class="input_login_site register_input_email"  id="register_input_email" data-local-placeholder="enterEmailPlaceholder" placeholder="Please Enter Email" >
            <div class="line"></div>
        </div>

        <div class="d-flex flex-row justify-content-center ">
            {{if enableInvitationCode == 1}}
            <button type="button" class="btn register_code_button"><span class="span_btn_tip" data-local-value="registerBtnCodeTip">下一步</span></button>
            {{else }}
            <button type="button" class="btn register_button"><span class="span_btn_tip" data-local-value="registerBtnTip">Register</span></button>
            {{/if}}
        </div>

        <div class="d-flex flex-row register_span_div login_span_div" >
            <span style="color:rgba(153,153,153,1);" data-local-value="hasAccountTip">Has Account?</span>
            <span onclick="registerForLogin()" data-local-value="loginTip">Login Account</span>
        </div>
    </div>
</script>


