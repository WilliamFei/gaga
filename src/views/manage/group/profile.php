<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Config Manage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!--    <link rel=stylesheet href="../../public/css/manage_base.css"/>-->

    <style>

        html, body {
            padding: 0px;
            margin: 0px;
            font-family: PingFangSC-Regular, "MicrosoftYaHei";
            /*overflow: hidden;*/
            width: 100%;
            height: 100%;
            background: rgba(245, 245, 245, 1);
            font-size: 10.66px;
            overflow-x: hidden;
            overflow-y: hidden;

        }

        /* mask and new window */
        .wrapper-mask {
            background: rgba(0, 0, 0, 0.8);
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: fixed;
            z-index: 9999;
            overflow: hidden;
            visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            width: 100%;
            /*height: 100%;*/
            /*display: flex;*/
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            display: flex;
            /*align-items: stretch;*/
            overflow: hidden;
            flex-shrink: 0;
        }

        .item-row {
            background: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 44px;
        }

        /*.item-row:hover{*/
        /*background: rgba(255, 255, 255, 0.2);*/
        /*}*/

        .item-row:active {
            background: rgba(255, 255, 255, 0.2);
        }

        .item-bottom {
            background: rgba(245, 245, 245, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 25px;
        }

        .item-header {
            width: 50px;
            height: 50px;
        }

        .site-manage-image {
            width: 40px;
            height: 40px;
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 16px;
            /*border-radius: 50%;*/
        }

        .site-logo-image {
            width: 30px;
            height: 30px;
            /*margin-top: 5px;*/
            margin-bottom: 7px;
            /*border-radius: 50%;*/
        }

        .item-body {
            width: 100%;
            height: 44px;
            /*margin-left: 1rem;*/
            /*margin-top: 5px;*/
            flex-direction: row;
            vertical-align: middle;
        }

        .list-item-center {
            width: 100%;
            /*height: 11rem;*/
            /*background: rgba(255, 255, 255, 1);*/
            padding-top: 20px;
            /*padding-left: 1rem;*/

        }

        .item-body-display {
            display: flex;
            justify-content: space-between;
            /*margin-right: 7rem;*/
            /*margin-bottom: 3rem;*/
            /*height: 100%;*/
            /*line-height: 3rem;*/
            margin-top: 7px;
        }

        .item-body-tail {
            text-align: right;
            margin-right: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            display: flex;
            /*height: 3rem;*/
            /*color: rgba(76, 59, 177, 1);*/
            /*line-height: 3rem;*/
        }

        .item-body-desc {
            /*height: 3rem;*/
            font-size: 16px;
            /*color: rgba(76, 59, 177, 1);*/
            margin-left: 10px;
        }

        .more-img {
            width: 8px;
            height: 13px;
            margin-top: 5px;
            /*border-radius: 50%;*/
        }

        .line {
            width: 28.14rem;
            height: 0.01rem;
            border: 0.09rem solid rgba(153, 153, 153, 1);
            overflow: hidden;
            text-align: center;
            margin: 0 auto;
            margin-top: 0.1rem;
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

        #popup-group {
            width: 50rem;
            height: 30rem;
            background: rgba(255, 255, 255, 1);
            border-radius: 0.94rem;
        }

        .header_tip_font {
            justify-content: center;
            text-align: center;
            margin-top: 5rem;
            height: 3.75rem;
            font-size: 2.63rem;
            color: rgba(76, 59, 177, 1);
            line-height: 3.75rem;
        }

        .popup-group-input {
            background-color: #ffffff;
            border-style: none;
            outline: none;
            height: 1.88rem;
            font-size: 1.88rem;
            font-family: PingFangSC-Regular;
            /*color: rgba(205, 205, 205, 1);*/
            line-height: 1.88rem;
            /*margin-left: 10rem;*/
            margin-top: 5rem;
            padding: 0.5rem;
            width: 55%;
            overflow: hidden;
        }

        .plugin-add-input {
            background-color: #ffffff;
            border-style: none;
            outline: none;
            font-size: 14px;
            font-family: PingFangSC-Regular;
            /*color: rgba(205, 205, 205, 1);*/
            /*line-height: 1.88rem;*/
            /*margin-left: 10rem;*/
            padding: 0.5rem;
            width: 200px;
            height: 5px;
            overflow: hidden;
            text-align: right;
        }

        .data_tip {
            height: 1.69rem;
            font-size: 1.31rem;
            font-family: PingFangSC-Regular;
            color: rgba(153, 153, 153, 1);
            line-height: 1.69rem;
            margin-left: 23rem;
            width: 29rem;
            word-break: break-all;
            padding: 0.5rem;
        }

        .create_button,
        .create_button:hover,
        .create_button:focus,
        .create_button:active {
            margin-top: 45px;
            width: 250px;
            height: 50px;
            background: rgba(76, 59, 177, 1);
            border-radius: 0.94rem;
            font-size: 16px;
            color: rgba(255, 255, 255, 1);
            line-height: 1.67rem;
        }

        .weui_switch {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            position: relative;
            width: 52px;
            height: 32px;
            border: 1px solid #DFDFDF;
            outline: 0;
            border-radius: 16px;
            box-sizing: border-box;
            background: #DFDFDF;
        }

        .weui_switch:checked {
            border-color: #4C3BB1;
            /*">#04BE02;*/
            background-color: #4C3BB1;
        }

        .weui_switch:before {
            content: " ";
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 30px;
            border-radius: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
            background-color: #FDFDFD;
            -webkit-transition: -webkit-transform .3s;
            transition: -webkit-transform .3s;
            transition: transform .3s;
            transition: transform .3s, -webkit-transform .3s;
        }

        .weui_switch:checked:before {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        .weui_switch:after {
            content: " ";
            position: absolute;
            top: 0;
            left: 0;
            width: 30px;
            height: 30px;
            border-radius: 15px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
            -webkit-transition: -webkit-transform .3s;
            transition: -webkit-transform .3s;
            transition: transform .3s;
            transition: transform .3s, -webkit-transform .3s;
        }

        .weui_switch:checked:after {
            -webkit-transform: translateX(20px);
            transform: translateX(20px);
        }

    </style>


    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>

</head>

<body>

<!--<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>-->

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row" id="group-id" data="<?php echo $groupId; ?>">

        <div class="list-item-center">

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群ID</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group ID</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value"><?php echo $groupId ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="user-nickname">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群组名称</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group Name</div>
                        <?php } ?>

                        <div class="item-body-tail" id="user-nickname-text">
                            <div class="item-body-value"><?php echo $name ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: group logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群组头像</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group Avatar</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../../public/img/manage/program_manage.png"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!-- part 2  register && login plugin-->
    <div class="layout-all-row">

        <div class="list-item-center">

            <div class="item-row" id="group-max-members">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设置最大成员</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Set Max Members</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <div class="item-body-value"><?php echo $maxMembers ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>
            <!--
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设置是否允许分享</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Share Group</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableShareGroup == 1) { ?>
                                <input id="enableShareGroupSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableShareGroupSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>-->

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设为站点默认群组</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Add Site Default Groups</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($isDefaultGroup == 1) { ?>
                                <input id="addDefaultGroupSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="addDefaultGroupSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!--   part 3  -->
    <div class="layout-all-row">

        <div class="list-item-center">
            <div class="item-row" id="manage-group-members">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群成员管理</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Manage Group Members</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>


    <!--   part 4  -->
    <div class="layout-all-row">

        <div class="list-item-center">
            <div class="item-row" id="remove-group">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">解散群组</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Remove Group</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-bottom">

            </div>
        </div>
    </div>

</div>

<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>

<div class="popup-template" style="visibility:hidden;">

    <div class="config-hidden" id="popup-group">

        <div class="flex-container">
            <div class="header_tip_font popup-group-title">创建群组</div>
        </div>

        <div class="" style="text-align: center">
            <input type="text" class="popup-group-input"
                   data-local-placeholder="enterGroupNamePlaceholder" placeholder="please input">
        </div>

        <div class="line"></div>

        <div class="" style="text-align:center;">
            <?php if ($lang == "1") { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();"> 修改
                </button>
            <?php } else { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();">Update
                </button>
            <?php } ?>
        </div>

    </div>

</div>


<script type="text/javascript">

    function isAndroid() {

        var userAgent = window.navigator.userAgent.toLowerCase();
        if (userAgent.indexOf("android") != -1) {
            return true;
        }

        return false;
    }

    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
            return true;
        }
        return false;
    }

    function getLanguage() {
        var nl = navigator.language;
        if ("zh-cn" == nl || "zh-CN" == nl) {
            return 1;
        }
        return 0;
    }


    function zalyjsAjaxPostJSON(url, body, callback) {
        zalyjsAjaxPost(url, jsonToQueryString(body), function (data) {
            var json = JSON.parse(data)
            callback(json)
        })
    }


    function zalyjsNavOpenPage(url) {
        var messageBody = {}
        messageBody["url"] = url
        messageBody = JSON.stringify(messageBody)

        if (isAndroid()) {
            window.Android.zalyjsNavOpenPage(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
        }
    }

    function zalyjsCommonAjaxGet(url, callBack) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (result) {

                callBack(url, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }


    function zalyjsCommonAjaxPost(url, value, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: value,
            success: function (result) {
                callBack(url, value, result);
            },
            error: function (err) {
                alert("error");
            }
        });

    }

    function zalyjsCommonAjaxPostJson(url, jsonBody, callBack) {
        $.ajax({
            url: url,
            method: "POST",
            data: jsonBody,
            success: function (result) {

                callBack(url, jsonBody, result);

            },
            error: function (err) {
                alert("error");
            }
        });

    }

    /**
     * _blank    在新窗口中打开被链接文档。
     * _self    默认。在相同的框架中打开被链接文档。
     * _parent    在父框架集中打开被链接文档。
     * _top    在整个窗口中打开被链接文档。
     * framename    在指定的框架中打开被链接文档。
     *
     * @param url
     * @param target
     */
    function zalyjsCommonOpenPage(url, target = "_blank") {
        window.open(url, target);
    }

</script>

<script type="text/javascript">

    function showWindow(jqElement) {
        jqElement.css("visibility", "visible");
        $(".wrapper-mask").css("visibility", "visible").append(jqElement);
    }


    function removeWindow(jqElement) {
        jqElement.remove();
        $(".popup-template").append(jqElement);
        $(".wrapper-mask").css("visibility", "hidden");
        $("#update-user-button").attr("data", "");
        $(".popup-group-input").val("");
        $(".popup-template").hide();
    }


    $(document).mouseup(function (e) {
        var targetId = e.target.id;
        var targetClassName = e.target.className;

        if (targetId == "wrapper-mask") {
            var wrapperMask = document.getElementById("wrapper-mask");
            var length = wrapperMask.children.length;
            var i;
            for (i = 0; i < length; i++) {
                var node = wrapperMask.children[i];
                node.remove();
                // addTemplate(node);
                $(".popup-template").append(node);
                $(".popup-template").hide();
            }
            $("#update-user-button").attr("data", "");
            $(".popup-group-input").val("");
            wrapperMask.style.visibility = "hidden";
        }
    });


    $(document).on("click", "#user-nickname", function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "name");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);

    });

    $(document).on("click", "#group-max-members", function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "maxMembers");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);
    });


    function updateConfirm() {
        var groupId = $("#group-id").attr("data");
        var value = $(".popup-group-input").val();
        var keyName = $("#update-user-button").attr("data");

        alert("groupId=" + groupId + " name=" + keyName + " value=" + value);

        if (keyName == null || keyName == "") {
            alert("update fail");
            return;
        }

        var data = {
            'groupId': groupId,
            'key': keyName,
            'value': value,
        };

        var url = "index.php?action=manage.group.update&lang=" + getLanguage();
        zalyjsCommonAjaxPostJson(url, data, updateGroupResponse)

        removeWindow($(".config-hidden"));
    }

    function updateGroupResponse(url, data, result) {
        alert(result);
    }

    //enable realName
    $("#enableShareGroupSwitch").change(function () {
        var groupId = $("#group-id").attr("data");
        var lang = getLanguage();
        var isChecked = $(this).is(':checked')
        var url = "index.php?action=manage.group.update&lang=" + lang;

        var data = {
            'groupId': groupId,
            'key': 'enableShareGroup',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, enableShareGroupResponse)
    });

    function enableShareGroupResponse(url, data, result) {
        alert(result);
    }


    $("#addDefaultGroupSwitch").change(function () {

        var groupId = $("#group-id").attr("data");
        var isChecked = $(this).is(':checked')
        var url = "index.php?action=manage.group.update&lang=" + getLanguage();


        alert("groupid=" + groupId);
        alert("key=" + 'addDefaultGroup');

        var data = {
            'groupId': groupId,
            'key': 'addDefaultGroup',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, addDefaultGroupResponse)

    });

    function addDefaultGroupResponse(url, data, result) {
        alert(result);
    }


    $(document).on("click", "#manage-group-members", function () {
        var groupId = $("#group-id").attr("data");

        var url = "index.php?action=manage.group.members&groupId=" + groupId + "&lang=" + getLanguage();

        zalyjsCommonOpenPage(url);
    });


    $(document).on("click", "#remove-group", function () {

        var groupId = $("#group-id").attr("data");

        var url = "index.php?action=manage.group.delete&lang=" + getLanguage();

        var data = {
            'groupId': groupId
        };

        zalyjsCommonAjaxPostJson(url, data, removeGroupResponse)
    });


    function removeGroupResponse(url, data, result) {
        alert(result);
    }


</script>


</body>
</html>




