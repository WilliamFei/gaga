<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>DuckChat 私有部署IM、社群运营神奇，支持iOS、Android、Web，最多支持500台服务器集群！</title>
    <link rel="stylesheet" href="../../public/css/zaly-action-row.css" />
    <link rel="stylesheet" href="../../public/css/zaly_contact.css" />
    <link rel="stylesheet" href="../../public/css/zaly_apply_friend_list.css" />
    <link rel="stylesheet" href="../../public/css/hint.min.css">
    <link rel="stylesheet" href="../../public/css/zaly_msg.css" />
    <link rel="stylesheet" media="(max-height: 650px)" href="../../public/css/zaly_media.css" />

    <script src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/template-web.js"></script>
    <script src="../../public/js/jquery.i18n.properties.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

</head>

<body>
    <!--左列， 以及会话帧-->
    <?php include(dirname(__DIR__) . '/base/baseView.php'); ?>
    <!-- 右边聊天窗口，包括消息帧 -->
    <div class="layout-right msg-chat-dialog" >
        <div class="chat-dialog" style="display: none">
            <?php include(dirname(__DIR__) . '/base/chatDialog.php'); ?>
        </div>
        <div  class="no-chat-dialog-div" style="display: none">
            <img src="../../public/img/msg/no_chat_dialog.png" style=" " class="no-chat-dialog">
        </div>
    </div>

    <div class="layout-right friend-apply-dialog" style="display: none;">
          <?php include(dirname(__DIR__) . '/base/friendApplyList.php'); ?>
    </div>
</div>

<?php include(dirname(__DIR__) . '/base/template.php'); ?>
<?php include(dirname(__DIR__) . '/base/template_msg.php'); ?>

<script src="../../public/js/im/zalyKey.js"></script>
<script src="../../public/js/im/zalyAction.js"></script>
<script src="../../public/js/im/zalyClient.js"></script>
<script src="../../public/js/im/zalyBaseWs.js"></script>
<script src="../../public/js/im/zalyIm.js"></script>
<script src="../../public/js/im/zalyMsg.js"></script>
<script src="../../public/js/im/zalyGroupMsg.js"></script>
<script src="../../public/js/zalyjsNative.js"></script>
<script src="../../public/js/im/zalyHelper.js"></script>
<script src="../../public/js/qrcode.js" ></script>
<script src="../../public/js/utf.js" ></script>
<script src="../../public/js/jquery.qrcode.js"></script>

<script type="text/javascript">

    $(window).resize(function () {
        setFontSize();
    });
    setFontSize();
    function setFontSize()
    {
        var rem = getRemPx();
        $('html').css('font-size', rem + "px");
    }

    function getRemPx()
    {
        var whdef = 10.66/1440;// 1440,使用10.66PX的默认值
        var wW = window.innerWidth;// 当前窗口的宽度
        var rem = wW * whdef;// 以默认比例值乘以当前窗口宽度,得到该宽度下的相应FONT-SIZE值
        if(rem < 8) {
            rem = 8;
        }
        if(rem > 10.66) {
            rem = 10.66;
        }
        return rem;
    }

    requestSiteConfig(ZalyIm);

    localStorage.setItem(chatTypeKey, DefaultChat);
    getRoomList();

    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });

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
        $(document).on("click", ".preemptiveVersionDiv", function(){
            var qqUrl = "https://jq.qq.com/?_wv=1027&k=5GBN4lJ";
            window.open(qqUrl);
        });

</script>

</body>
</html>




