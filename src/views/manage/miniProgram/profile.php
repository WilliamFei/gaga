<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Config Manage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css"/>
    <link rel="stylesheet" href="https://cdn.bootcss.com/jquery-weui/1.2.0/css/jquery-weui.css"/>

    <style>

        html, body {
            padding: 0px;
            margin: 0px;
            font-family: PingFangSC-Regular, "MicrosoftYaHei";
            /*overflow: hidden;*/
            width: 100%;
            height: 100%;
            background: rgba(245, 244, 249, 1);
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
            background: rgba(255, 255, 255, 0.2);
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
            margin-top: 2rem;
            width: 100%;
            height: 44px;
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

        .site-image {
            width: 30px;
            height: 30px;
            /*margin-top: 5px;*/
            margin-bottom: 7px;
            /*border-radius: 50%;*/
            cursor: pointer;
        }

        .item-body-value {
            margin-right: 5px;
        }

    </style>


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

</head>

<body>

<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row">

        <div class="list-item-center">


            <div class="item-row" id="mini-program-id" data="<?php echo $pluginId ?>">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">小程序ID</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Mini Program Id</div>
                        <?php } ?>

                        <div class="item-body-tail" style="margin-right: 20px">
                            <?php echo $pluginId ?>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: site name      -->
            <div class="item-row" id="mini-program-name" data="<?php $name ?>">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">小程序名称</div>
                            <div class="item-body-tail">
                                <input id="mini-program-name-text" type="text" class="plugin-add-input"
                                       placeholder="请输入小程序名称" value="<?php echo $name ?>">
                            </div>
                        <?php } else { ?>
                            <div class="item-body-desc">Mini Program Name</div>
                            <div class="item-body-tail">
                                <input id="mini-program-name-text" type="text" class="plugin-add-input"
                                       placeholder="input mini program name" value="<?php echo $name ?>">
                            </div>
                        <?php } ?>


                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">小程序图标</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Mini Program Icon</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <div class="item-body-value" id="mini-program-img-id" fileId="<?php echo $logo ?>">
                                <img id="mini-program-img" class="site-image"
                                     onclick="uploadFile('mini-program-img-input')"
                                     src="">

                                <input id="mini-program-img-input" type="file" onchange="uploadImageFile(this)"
                                       accept="image/gif,image/jpeg,image/jpg,image/png,image/svg"
                                       style="display: none;">
                            </div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
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

            <div class="item-row" id="mini-program-landing-page" data="<?php echo $landingPageUrl ?>">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">落地页URL</div>
                            <div class="item-body-tail">
                                <input id="mini-program-landing-text" type="text" class="plugin-add-input"
                                       placeholder="纯网页小程序请填写页面完整URL" value="<?php echo $landingPageUrl ?>">
                            </div>
                        <?php } else { ?>
                            <div class="item-body-desc">Home Page Url</div>
                            <div class="item-body-tail">
                                <input id="mini-program-landing-text" type="text" class="plugin-add-input"
                                       placeholder="纯网页小程序请填写页面完整URL" value="<?php echo $landingPageUrl ?>">
                            </div>
                        <?php } ?>


                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">是否开启站点代理请求</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Open Site HTTP Proxy</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($landingPageWithProxy == "1") { ?>
                                <input id="openProxySwitch-text" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="openProxySwitch-text" class="weui_switch" type="checkbox">
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
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display mini-program-usage" data="<?php echo $usageType ?>">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">小程序使用类别</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Mini Program Usage</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div id="mini-program-usage-text" style="margin-right: 4px">
                                <?php if ($usageType == "1") { ?>
                                    <?php if ($lang == "1") { ?> 首页小程序<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($usageType == "2") { ?>
                                    <?php if ($lang == "1") { ?> 登陆小程序<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($usageType == "3") { ?>
                                    <?php if ($lang == "1") { ?> 二人聊天小程序<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($usageType == "4") { ?>
                                    <?php if ($lang == "1") { ?> 临时会话小程序<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($usageType == "5") { ?>
                                    <?php if ($lang == "1") { ?> 聊天界面底部小程序<?php } else { ?> Home Page <?php } ?>
                                <?php } ?>
                            </div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="mini-program-order">
                <div class="item-body">
                    <div class="item-body-display mini-program-order">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">小程序顺序</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Mini Program Order</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <input id="mini-program-order-text" class="plugin-add-input" type="text"
                                   value="<?php echo $sort ?>">
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display mini-program-display" data="<?php echo $loadingType ?>">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">展示方式</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Display Mode</div>
                        <?php } ?>

                        <div class="item-body-tail">

                            <div id="mini-program-display-text" style="margin-right: 4px">
                                <?php if ($loadingType == "0") { ?>
                                    <?php if ($lang == "1") { ?> 新页面打开<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($loadingType == "1") { ?>
                                    <?php if ($lang == "1") { ?> 悬浮打开<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($loadingType == "2") { ?>
                                    <?php if ($lang == "1") { ?> Mask打开<?php } else { ?> Home Page <?php } ?>
                                <?php } else if ($loadingType == "3") { ?>
                                    <?php if ($lang == "1") { ?> Chatbox打开<?php } else { ?> Chatbox Page <?php } ?>
                                <?php } else if ($loadingType == "4") { ?>
                                    <?php if ($lang == "1") { ?> 全屏打开<?php } else { ?> Full Screen <?php } ?>
                                <?php } ?>
                            </div>

                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display mini-program-permission" data="<?php echo $permissionType ?>">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">使用权限</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Use Permission</div>
                        <?php } ?>

                        <div class="item-body-tail">

                            <div id="mini-program-permission-text" style="margin-right: 4px">
                                <?php if ($loadingType == "0") { ?>
                                    <?php if ($lang == "1") { ?> 管理员可用<?php } else { ?> Managers Available<?php } ?>
                                <?php } else if ($loadingType == "1") { ?>
                                    <?php if ($lang == "1") { ?> 所有人可用<?php } else { ?> All Users Available<?php } ?>
                                <?php } else if ($loadingType == "2") { ?>
                                    <?php if ($lang == "1") { ?> 群管理可用<?php } else { ?> Group Master Available<?php } ?>
                                <?php } ?>
                            </div>

                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display mini-program-secret-key">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">安全秘钥</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Secret Key</div>
                        <?php } ?>

                        <div class="item-body-tail" style="margin-right: 25px">
                            <?php echo $authKey ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>

</div>


<div class="popup-template" style="visibility:hidden;">

    <div class="config-hidden" id="popup-group">

        <div class="flex-container">
            <div class="header_tip_font popup-group-title" data-local-value="createGroupTip">创建群组</div>
        </div>

        <div class="" style="text-align: center">
            <input type="text" class="popup-group-input" placeholder="please input">
        </div>

        <div class="line"></div>

        <div class="" style="text-align:center;">
            <?php if ($lang == "1") { ?>
                <button type="button" class="create_button" url-value="">保存</button>
            <?php } else { ?>
                <button type="button" class="create_button" url-value="">Save</button>
            <?php } ?>
        </div>

    </div>

</div>


<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
<!--<script type="text/javascript" src="https://res.wx.qq.com/open/libs/weuijs/1.1.3/weui.min.js"></script>-->
<script type="text/javascript" src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.js"></script>

<script type="text/javascript">

    function uploadFile(obj) {
        $("#" + obj).val("");
        $("#" + obj).click();
    }


    function uploadImageFile(obj) {
        if (isMobile()) {
            //mobile
            alert("alert");
        } else {

            if (obj) {
                if (obj.files) {
                    var formData = new FormData();

                    formData.append("file", obj.files.item(0));
                    formData.append("fileType", "FileImage");
                    formData.append("isMessageAttachment", false);

                    var src = window.URL.createObjectURL(obj.files.item(0));

                    uploadFileToServer(formData, src);

                    //直接放图片
                    $("#mini-program-img").attr("src", src);
                }
                return obj.value;
            }
        }
    }

    function uploadFileToServer(formData, src) {
        $.ajax({
            url: "./index.php?action=http.file.uploadWeb",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (imageFileId) {
                console.log("imageId ==" + imageFileId);
                if (imageFileId) {
                    updateMiniProgramProfile("logo", imageFileId);
                }
            },
            error: function (err) {
                alert("update image error");
                return false;
            }
        });
    }

    function showImage(fileId, htmlImgId) {
        var requestUrl = "./index.php?action=http.file.downloadMessageFile&fileId=" + fileId + "&returnBase64=0";
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && (this.status == 200 || this.status == 304)) {
                var blob = this.response;
                var src = window.URL.createObjectURL(blob);

                $("#" + htmlImgId).attr("src", src);
            }
        };
        xhttp.open("GET", requestUrl, true);
        xhttp.responseType = "blob";
        // xhttp.setRequestHeader('Cache-Control', "max-age=2592000, public");
        xhttp.send();
    }

    $(function () {
        var fileId = $("#mini-program-img-id").attr("fileId");
        showImage(fileId, 'mini-program-img');
    });

    $("#mini-program-name-text").blur(function () {
        var name = $(this).val();
        updateMiniProgramProfile("name", name);
    });


    $("#mini-program-landing-text").blur(function () {
        var value = $(this).val();
        updateMiniProgramProfile("landingPageUrl", value);
    });

    $("#mini-program-order-text").blur(function () {
        var value = $(this).val();
        updateMiniProgramProfile("sort", value);
    });

    //enable tmp chat
    $("#openProxySwitch-text").change(function () {
        var isChecked = $(this).is(':checked')

        var value = 0;
        if (isChecked) {
            value = 1;
        }

        updateMiniProgramProfile("landingPageWithProxy", value);
    });

    $(document).on("click", '.mini-program-usage', function () {

        // PluginUsageIndex = 1;
        // PluginUsageLogin = 2;
        //
        // PluginUsageU2Message = 3;
        // PluginUsageTmpMessage = 4;
        // PluginUsageGroupMessage = 5;
        var language = getLanguage();
        var url = "index.php?action=manage.miniProgram.update&type=usageType&lang=" + language;
        $.actions({
            title: "",
            onClose: function () {
                console.log("close");
            },
            actions: [{
                text: language == 0 ? "Home Mini Program" : "首页小程序",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-usage-text").html(language == 0 ? "Home Page" : "首页小程序");
                    $(".mini-program-usage").attr("data", "1");
                    updateMiniProgramProfile("usageType", "1");
                }
            }, {
                text: language == 0 ? "U2 Chat Mini Program" : "二人聊天小程序",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-usage-text").html(language == 0 ? "U2 Chat Mini Program" : "二人聊天小程序");
                    $(".mini-program-usage").attr("data", "3");
                    updateMiniProgramProfile("usageType", "3");
                }
            }, {
                text: language == 0 ? "Tmp Chat Mini Program" : "临时会话小程序",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-usage-text").html(language == 0 ? "Tmp Chat Mini Program" : "临时会话小程序");
                    $(".mini-program-usage").attr("data", "4");
                    updateMiniProgramProfile("usageType", "4");
                }
            }, {
                text: language == 0 ? "Group Chat Mini Program" : "群组聊天小程序",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-usage-text").html(language == 0 ? "Chat Page Bottom" : "聊天界面底部");
                    $(".mini-program-usage").attr("data", "5");
                    updateMiniProgramProfile("usageType", "5");
                }
            }, {
                text: language == 0 ? "Login Mini Program" : "登陆小程序",
                className: "color-warning weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-usage-text").html(language == 0 ? "Login Mini Program" : "登陆小程序");
                    $(".mini-program-usage").attr("data", "2");
                    updateMiniProgramProfile("usageType", "2");
                }
            }]
        });
    });

    $(document).on("click", '.mini-program-display', function () {

        var language = getLanguage();
        // PluginLoadingNewPage = 0;
        // PluginLoadingFloat   = 1;
        // PluginLoadingMask    = 2;
        // PluginLoadingChatbox = 3;
        // PluginLoadingFullScreen = 4;

        $.actions({
            title: "",
            onClose: function () {
                console.log("close");
            },
            actions: [{
                text: language == 0 ? "New Page" : "新页面打开",
                className: "color-primary weui-dialog__btn ",
                onClick: function () {
                    $("#mini-program-display-text").html(language == 0 ? "New Page" : "新页面打开");
                    $(".mini-program-display").attr("data", "0");
                    updateMiniProgramProfile("loadingType", "0");
                }
            }, {
                text: language == 0 ? "Float Page" : "悬浮打开",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-display-text").html(language == 0 ? "Float Page" : "悬浮打开打开");
                    $(".mini-program-display").attr("data", "1");
                    updateMiniProgramProfile("loadingType", "1");
                }
            }, {
                text: language == 0 ? "Mask Page" : "Mask打开",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-display-text").html(language == 0 ? "Mask Page" : "Mask打开");
                    $(".mini-program-display").attr("data", "2");
                    updateMiniProgramProfile("loadingType", "2");
                }
            }, {
                text: language == 0 ? "Chatbox Page" : "Chatbox打开",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-display-text").html(language == 0 ? "Chatbox Page" : "Chatbox打开");
                    $(".mini-program-display").attr("data", "3");
                    updateMiniProgramProfile("loadingType", "3");
                }
            }, {
                text: language == 0 ? "FullScreen" : "全屏打开",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-display-text").html(language == 0 ? "FullScreen" : "全屏打开");
                    $(".mini-program-display").attr("data", "4");
                    updateMiniProgramProfile("loadingType", "4");
                }
            }]
        });
    });


    $(document).on("click", '.mini-program-permission', function () {

        var language = getLanguage();
        // PluginPermissionAdminOnly   = 0;
        // PluginPermissionAll     = 1;
        // PluginPermissionGroupMaster = 2;

        $.actions({
            title: "",
            onClose: function () {
                console.log("close");
            },
            actions: [{
                text: language == 0 ? "All User Available" : "所有人可用",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-permission-text").html(language == 0 ? "All User Available" : "所有人可用");
                    $(".mini-program-permission").attr("data", "1");
                    updateMiniProgramProfile("permissionType", "1");
                }
            }, {
                text: language == 0 ? "Group Master Available" : "群管理员可用",
                className: "color-primary weui-dialog__btn",
                onClick: function () {
                    $("#mini-program-permission-text").html(language == 0 ? "Group Master Available" : "群管理员可用");
                    $(".mini-program-permission").attr("data", "2");
                    updateMiniProgramProfile("permissionType", "2");
                }
            }, {
                text: language == 0 ? "Site Managers Available" : "站点管理员可用",
                className: "color-primary weui-dialog__btn ",
                onClick: function () {
                    $("#mini-program-permission-text").html(language == 0 ? "Site Managers Available" : "站点管理员可用");
                    $(".mini-program-permission").attr("data", "0");
                    updateMiniProgramProfile("permissionType", "0");
                }
            }]
        });
    });


    function updateMiniProgramProfile(name, value) {

        var language = getLanguage();

        var pluginId = $("#mini-program-id").attr("data");

        alert("pluginId=" + pluginId + "name=" + name + " value=" + value);

        var data = {
            'pluginId': pluginId,
            'name': name,
            'value': value
        };

        var url = "index.php?action=manage.miniProgram.update&lang=" + language;

        zalyjsCommonAjaxPostJson(url, data, updateProfileResponse);
    }

    function updateProfileResponse(url, jsonData, result) {
        if (result) {
            var resJson = JSON.parse(result);

            var errCode = resJson['errCode'];

            if ("success" == errCode) {
                alert("update mini program success");
                window.location.reload();
            } else {
                var errInfo = resJson['errInfo'];
                alert("error:" + errInfo);
            }
        } else {
            alert("error");
        }
    }

</script>

</body>
</html>




