<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../../public/css/init.css">
</head>
<body>

<div class="zaly_container" >
    <div class="zaly_login zaly_login_by_phone">
        <div class="initDiv " style="margin-top:2rem;" >
            <div class="initHeader" style="">
                检测站点信息
            </div>
            <div class="init_check_info margin-top5 " isLoad="<?php echo $isLoadOpenssl;?>">
                <div  class="init_check">
                    PHP版本大于5.6
                </div>
                <div class="init_check_result">
                    <?php if($isPhpVersionValid){ echo " <img src='../../public/img/msg/member_select.png' />
"; } else { echo "<img src='../../public/img/msg/btn-x.png'  />" ;}?>
                </div>
            </div>

            <div class="init_check_info  ext_open_ssl" isLoad="<?php echo $isLoadOpenssl;?>" >
                <div  class="init_check">
                    是否支持OpenSSL
                </div>
                <div class="init_check_result" >
                 <?php if($isLoadOpenssl==1){ echo " <img src='../../public/img/msg/member_select.png'/>
"; } else { echo "<img src='../../public/img/msg/btn-x.png' />" ;}?>
                </div>
            </div>

            <div class=" init_check_info justify-content-left  ext_pdo_sqlite" isLoad="<?php echo $isLoadPDOSqlite;?>" >
                <div  class="init_check">
                    是否安装PDO_Sqlite
                </div>
                <div class="init_check_result">
                <?php if($isLoadPDOSqlite==1){ echo " <img src='../../public/img/msg/member_select.png' />
"; } else { echo "<img src='../../public/img/msg/btn-x.png' />" ;}?>
                </div>
            </div>

            <div class="init_check_info justify-content-left ext_curl"  isLoad="<?php echo $isLoadCurl;?>" >
                <div  class="init_check">
                    是否安装Curl
                </div>
                <div class="init_check_result">

                <?php if($isLoadCurl==1){ echo " <img src='../../public/img/msg/member_select.png'/>
"; } else { echo "<img src='../../public/img/msg/btn-x.png'  />" ;}?>
                </div>
            </div>

            <div class="init_check_info justify-content-left  ext_is_write"  isLoad="<?php echo $isWritePermission;?>" >
                <div  class="init_check">
                    当前目录写权限
                </div>
                <div class="init_check_result">

                <?php if($isWritePermission==1){ echo " <img src='../../public/img/msg/member_select.png'/>
"; } else { echo "<img src='../../public/img/msg/btn-x.png'  />" ;}?>
                </div>
            </div>

            <div class="init_check_info input_div justify-content-between " >
                <div  class="init_check">

                请选择登录方式：
                </div>
                <div class="init_check_result choose_login_type">
                    <select id="verifyPluginId" >
                        <option class="selectOption" pluginId="105">本地账户密码校验</option>
                        <option  class="selectOption"  pluginId="100">平台校验</option>
                    </select>
                </div>
            </div>


            <div class="d-flex flex-row justify-content-center " style="text-align: center;margin-bottom: 7rem;">
                <button type="button" class="btn login_button" ><span class="span_btn_tip">初始化数据</span></button>
            </div>
        </div>
    </div>

</div>


<script src="../../public/js/jquery.min.js"></script>
<script>
    $(document).on("click", ".login_button",function () {
         var isLoadOpenssl = $(".ext_open_ssl").attr("isLoad");
         var isPdoSqlite = $(".ext_pdo_sqlite").attr("isLoad");
         var isCurl = $(".ext_curl").attr("isLoad");
         var isWrite = $(".ext_is_write").attr("isLoad");

         if(isLoadOpenssl != 1) {
            alert("请先安装openssl");
            return false;
         }
         if(isPdoSqlite != 1) {
            alert("请先安装pdo_sqlite");
            return false;
         }
         if(isCurl != 1) {
            alert("请先安装is_curl");
            return false;
         }

         if(isWrite != 1) {
             alert("当前目录不可写");
             return false;
         }

        var selector = document.getElementById('verifyPluginId');
        var pluginId = $(selector[selector.selectedIndex]).attr("pluginId");
        var data = {
            pluginId : pluginId,
        };
        $.ajax({
            method: "POST",
            url:"./index.php?action=installDB",
            data: data,
            success:function (resp) {
                console.log("init db sqlite " + resp);
                if(resp == "success") {
                    window.location.href="./index.php?action=page.logout";
                } else {
                    alert("初始化失败");
                }
            }
        });
    });
    </script>
</body>
</html>
