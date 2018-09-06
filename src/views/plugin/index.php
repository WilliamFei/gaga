<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <!-- Latest compiled and minified CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="../../public/js/jquery.min.js"></script>
    <script src="../../public/js/zalyjsNative.js"></script>
    <script src="../../public/js/template-web.js"></script>
    <style>
        body, html {
            font-size: 10.66px;
        }
        .zaly_container {
        }
        .gif {
            width:5rem;
            height:5rem;
            margin-left: 2rem;
            margin-top: 3rem;
        }
        .gif_div_hidden {
            display: none;
        }
        .sliding {
            margin-right: 1rem;
            width:5px;
        }
        .slide_div {
            margin-top: 3rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="zaly_container" >
    <input type="hidden" class="gifs" value='<?php echo $gifs;?>'>
</div>

<div class="slide_div">

</div>
<?php include(dirname(__DIR__) . '/login/template_login.php'); ?>

<script src="../../public/js/im/zalyKey.js"></script>
<script src="../../public/js/im/zalyAction.js"></script>
<script src="../../public/js/im/zalyClient.js"></script>
<script src="../../public/js/im/zalyBaseWs.js"></script>

<script type="text/javascript">
    gifs  = $(".gifs").val();
    gifArr = JSON.parse(gifs);
    gifLength = gifArr.length + 1;
    var line = 0;
    console.log(line);
    console.log("gifLength ==" +gifLength)
    if(gifLength>1) {
        for(var i=1; i<gifLength ;i ++) {
            var gif = gifArr[i];
            try{
                var url = gif.url;
            }catch (error) {
            }
            if(i == 1) {
                var html = '';
                line = line+1;
                html = "<div class='gif_div gif_div_0'  gif-div='"+(line-1)+"'>";
            }
            if((i-9)%10 == 1) {
                var html = '';
                line = line+1;
                var divNum = Math.ceil(((i-9)/10));
                html = "<div class='gif_div gif_div_hidden gif_div_"+divNum+"' gif-div='"+(line-1)+"'>";
            }

            if(i==1) {
                html += "<img src='../../public/img/add.png' class='gif'>";
            }

            html += "<img src='"+url+"' class='gif'>";
            if(i==4) {
                html +="<br/>";
            } else if (i>5 && (i-5)%5 == 4) {
                html +="<br/>";
            }

            if((i-9)%10 == 0){
                html += "<div/>";
                $(".zaly_container").append(html);
            } else if(i == gifLength-1) {
                html += "<div/>";
                $(".zaly_container").append(html);
            }
        }
    }
    var slideHtml = "";
    for(var i=0; i<line; i++){
        slideHtml += "<img src='../../public/gif/sliding_unselect.png' select_gif_div= '"+i+"' class='sliding sliding_img sliding_uncheck sliding_uncheck_"+i+"'/>";
        $(".slide_div").html(slideHtml);
    }

    currentGifDivNum = 0;

    var flag = false;

    $(".gif").on('touchstart click', function(event){
        if(!flag) {
            flag = true;
            console.log("click");
            event.stopPropagation();
            event.preventDefault();
            var msgContent = $(this).attr("src");
            var roomId = "cdjpe3";
            var roomType = GROUP_MSG;
            sendGifMsg(roomId, roomType, msgContent);
            setTimeout(function(){ flag = false; }, 100);
        }
        return false
    });


    $(".zaly_container").on("touchstart", function(e) {
        e.preventDefault();
        startX = e.originalEvent.changedTouches[0].pageX,
            startY = e.originalEvent.changedTouches[0].pageY;
    });

    $(".zaly_container").on("touchend", function(e) {
        e.preventDefault();
        moveEndX = e.originalEvent.changedTouches[0].pageX,
            moveEndY = e.originalEvent.changedTouches[0].pageY,
            X = moveEndX - startX,
            Y = moveEndY - startY;

        if ( Math.abs(X) > Math.abs(Y) && X > 0 ) {
            ////右滑喜欢
            if(currentGifDivNum == 0) {
                return;
            }
            rightSlide();
        }
        else if ( Math.abs(X) > Math.abs(Y) && X < 0 ) {
            ////左滑不喜欢
            if(currentGifDivNum == (line-1)) {
                return;
            }
            leftSlide();
        }
    });


    function sendGifMsg(roomId, roomType, msgContent)
    {
        var msgId  = Date.now();

        var message = {};
        message['fromUserId'] = "e6ba56207153862f8fd94b325ca3daff91379127";
        var msgIdSuffix = "";
        if(roomType == U2_MSG) {
            message['roomType'] = U2_MSG;
            message['toUserId'] = roomId
            msgIdSuffix = "U2-";
        } else {
            message['roomType'] = GROUP_MSG;
            message['toGroupId'] = roomId;
            msgIdSuffix = "GROUP-";
        }
        var msgId = msgIdSuffix + msgId+"";
        message['msgId'] = msgId;

        message['timeServer'] = Date.parse(new Date());
        message['type'] = MessageType.MessageWeb;
        message['web'] = {code:"<img src='"+msgContent+"'>", width:200, height:200, hrefURL:msgContent}
        var action = "duckchat.message.send";
        var reqData = {
            "message" : message
        };

        handleClientSendRequest(action, reqData, handleSendGifMsg);
    }

    function handleSendGifMsg()
    {
        consol.log("handleSendGifMsg");
    }


    function leftSlide()
    {
        var oldGifDivNum = currentGifDivNum;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "none";
        currentGifDivNum = currentGifDivNum + 1;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "block";
        changeSlideImg(oldGifDivNum);
    }

    function rightSlide()
    {
        var oldGifDivNum = currentGifDivNum;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "none";
        currentGifDivNum = currentGifDivNum -1;
        $(".gif_div_"+currentGifDivNum)[0].style.display = "block";
        changeSlideImg(oldGifDivNum);
    }

    function changeSlideImg(oldGifDivNum)
    {
        var selectImg = "../../public/gif/sliding_select.png";
        $("[select_gif_div='"+currentGifDivNum+"']").attr("src", selectImg);

        var unSelectImg = "../../public/gif/sliding_unselect.png";
        $("[select_gif_div='"+oldGifDivNum+"']").attr("src", unSelectImg);
    }


</script>
</body>
</html>
