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
            background: rgba(245, 245, 245, 1);
            font-size: 10.66px;
            overflow-x: hidden;
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
            cursor: pointer;
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
            position: relative;
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

        .item-body-value {
            margin-right: 5px;
        }

        .more-img {
            width: 8px;
            height: 13px;
            margin-top: 5px;
            /*border-radius: 50%;*/
        }

        .line {
            width: 250px;
            height: 1px;
            border: 0.5px solid rgba(153, 153, 153, 1);
            overflow: hidden;
            text-align: center;
            margin: 0 auto;
            /*margin-top: 0.1rem;*/
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

        #popup-group {
            width: 640px;
            height: 350px;
            background: rgba(255, 255, 255, 1);
            border-radius: 10px;
        }

        .header_tip_font {
            justify-content: center;
            text-align: center;
            margin-top: 40px;
            height: 10px;
            font-size: 30px;
            color: rgba(76, 59, 177, 1);
            /*line-height: 3.75rem;*/
        }

        .popup-group-input {
            background-color: #ffffff;
            border-style: none;
            outline: none;
            /*height: 1.88rem;*/
            font-size: 20px;
            font-family: PingFangSC-Regular;
            /*color: rgba(205, 205, 205, 1);*/
            line-height: 1.88rem;
            /*margin-left: 10rem;*/
            margin-top: 100px;
            /*padding: 0.5rem;*/
            width: 250px;
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

</head>

<body>

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row" id="site-name">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">站点名称</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Site Name</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value"><?php echo $name; ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: site logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">站点 Logo</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Site Logo</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <div class="item-body-value" id="site-logo-fileid" fileId="<?php echo $logo ?>">
                                <img class="site-logo-image" onclick="uploadFile('upload-site-logo')" src="">

                                <input id="upload-site-logo" type="file" onchange="uploadImageFile(this)"
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

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">是否开启手机号</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Phone Number</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <?php if ($enableRealName == 1) { ?>
                                <input id="enableRealNameSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableRealNameSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">是否开启邀请码</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Invite Code</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableInvitationCode == 1) { ?>
                                <input id="enableUicSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableUicSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">登陆小程序ID</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Login Mini Program ID</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php echo $loginPluginId; ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>

    </div>

    <!-- part 3   -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">允许互相添加好友</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Add Friend</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableAddFriend == 1) { ?>
                                <input id="enableAddFriendSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableAddFriendSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">允许临时会话</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Tmp Chat</div>
                        <?php } ?>


                        <div class="item-body-tail">
                            <?php if ($enableTmpChat == 1) { ?>
                                <input id="enableTmpChatSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableTmpChatSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">允许创建群组</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Create Group</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableCreateGroup == 1) { ?>
                                <input id="enableCreateGroupSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableCreateGroupSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="group-max-members">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">群组最大成员数</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Group Max Members</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value"><?php echo $maxGroupMembers ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body" id="push-notice-type" data="<?php echo $pushType ?>">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">Push推送通知类型</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Push Notice Type</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <div class="item-body-value" id="push-notice-type-text">
                                <?php if ($pushType == "0") { ?>
                                    <?php if ($lang == "1") { ?> 禁止推送通知<?php } else { ?> Push Disable <?php } ?>
                                <?php } else if ($pushType == "1") { ?>
                                    <?php if ($lang == "1") { ?> 不显示文本内容<?php } else { ?> Hide Content <?php } ?>
                                <?php } else if ($pushType == "2") { ?>
                                    <?php if ($lang == "1") { ?> 显示文本内容<?php } else { ?> Show Content <?php } ?>
                                <?php } ?>
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


    <!--   part 4 -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">允许分享群聊</div>
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
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">允许分享个人</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Enable Share User</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($enableShareUser == 1) { ?>
                                <input id="enableShareUserSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="enableShareUserSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>


    <!--   part 5 -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">开启SSL功能</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Open SSL</div>
                        <?php } ?>

                        <!--                        <div class="item-body-desc">ZALY SSL PORT</div>-->
                        <!--                        <div class="item-body-desc">WS SSL PORT</div>-->
                        <div class="item-body-tail">
                            <?php if ($lang == "1") { ?>
                                暂不支持此功能
                            <?php } else { ?>
                                nonsupport
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">开启Web版本</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Open Web Edition</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($openWebEdition == 1) { ?>
                                <input id="openWebEditionSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="openWebEditionSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>


            <?php if ($openWebEdition == 1) { ?>
            <div class="division-line"></div>
            <div class="item-row" id="web-ws-port">
                <?php }else{ ?>
                <div class="division-line"></div>
                <div class="item-row" style="display: none;" id="web-ws-port">
                    <?php } ?>
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">WebSocket端口</div>
                            <?php } else { ?>
                                <div class="item-body-desc">WebSocket Port</div>
                            <?php } ?>

                            <div class="item-body-tail">
                                <div class="item-body-value"><?php
                                    if (isset($wsPort) && $wsPort != 0) {
                                        echo $wsPort;
                                    }
                                    ?></div>
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="division-line"></div>


                <div class="item-row">
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">是否开启Web挂件功能</div>
                            <?php } else { ?>
                                <div class="item-body-desc">enable Web-Widget</div>
                            <?php } ?>

                            <div class="item-body-tail">
                                <?php if ($enableWebWidget == 1) { ?>
                                    <input id="enableWebWidgetSwitch" class="weui_switch" type="checkbox" checked>
                                <?php } else { ?>
                                    <input id="enableWebWidgetSwitch" class="weui_switch" type="checkbox">
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="division-line"></div>
            </div>
        </div>


        <!--  part 6  -->
        <div class="layout-all-row">

            <div class="list-item-center">

                <div class="item-row" id="site-managers">
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">站点管理员</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Site Managers</div>
                            <?php } ?>

                            <div class="item-body-tail">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="division-line"></div>

                <div class="item-row" id="site-default-friends">
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">站点默认好友</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Site Default Friends</div>
                            <?php } ?>

                            <div class="item-body-tail">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="division-line"></div>

                <div class="item-row" id="site-default-groups">
                    <div class="item-body">
                        <div class="item-body-display">

                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">站点默认群组</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Site Default Groups</div>
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

        <!--   part 7  -->
        <div class="layout-all-row">

            <div class="list-item-center">

                <div class="item-row" id="site-rsa-pubk-pem">
                    <div class="item-body">
                        <div class="item-body-display">

                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">站点公钥</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Site Public Key</div>
                            <?php } ?>

                            <div class="item-body-tail">
                                <img class="more-img"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="division-line"></div>

                <div class="item-row" id="site-owner" siteOwner="<?php echo $owner ?>">
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">站长</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Site Administrator</div>
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
                <div class="header_tip_font popup-group-title" data-local-value="createGroupTip">创建群组</div>
            </div>

            <div class="" style="text-align: center">
                <input type="text" class="popup-group-input"
                       data-local-placeholder="enterGroupNamePlaceholder" placeholder="please input">
            </div>

            <div class="line"></div>

            <div class="" style="text-align:center;">
                <?php if ($lang == "1") { ?>
                    <button id="updatePopupButton" type="button" class="create_button" key-value=""
                            onclick="updateDataValue();">确认
                    </button>
                <?php } else { ?>
                    <button id="updatePopupButton" type="button" class="create_button" key-value=""
                            onclick="updateDataValue();">Confirm
                    </button>
                <?php } ?>
            </div>

        </div>

    </div>


    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery-confirm/3.1.0/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery-weui/1.2.0/js/jquery-weui.js"></script>

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

        function uploadFile(obj) {
            $("#" + obj).val("");
            $("#" + obj).click();
        }


        function uploadImageFile(obj) {
            console.log("ismobile:" + isMobile());
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

                        //上传以后本地展示的
                        // $(".user-image-upload").attr("src", src);
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
                        updateSiteLogo(imageFileId);
                    }
                },
                error: function (err) {
                    alert("update image error");
                    return false;
                }
            });
        }

        function updateSiteLogo(imageFileId) {
            var url = "index.php?action=manage.config.update";
            var data = {
                'key': 'logo',
                'value': imageFileId,
            };
            zalyjsCommonAjaxPostJson(url, data, updateLogoResponse);
        }

        function updateLogoResponse(url, data, result) {
            var res = JSON.parse(result);

            if (res.errCode) {

                var fileId = data.value;
                console.log("updateLogoResponse imageId fileId==" + fileId);

                showSiteLogo(fileId);
            } else {
                alert("errorInfo:" + res.errInfo);
            }
        }

        function showSiteLogo(fileId) {
            var requestUrl = "./index.php?action=http.file.downloadMessageFile&fileId=" + fileId + "&returnBase64=0";
            var xhttp = new XMLHttpRequest();
            console.log("showSiteLogo imageId ==" + fileId);

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && (this.status == 200 || this.status == 304)) {
                    var blob = this.response;
                    var src = window.URL.createObjectURL(blob);
                    console.log("showSiteLogo imageId response src=" + src);
                    $(".site-logo-image").attr("src", src);
                }
            };
            xhttp.open("GET", requestUrl, true);
            xhttp.responseType = "blob";
            // xhttp.setRequestHeader('Cache-Control', "max-age=2592000, public");
            xhttp.send();
        }

        function showWindow(jqElement) {
            jqElement.css("visibility", "visible");
            $(".wrapper-mask").css("visibility", "visible").append(jqElement);
        }


        function removeWindow(jqElement) {
            jqElement.remove();
            $(".popup-template").append(jqElement);
            $(".wrapper-mask").css("visibility", "hidden");
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
                $(".popup-group-input").val("");
                $("#updatePopupButton").attr("data", "");
                wrapperMask.style.visibility = "hidden";
            }
        });


        $(function () {
            var fileId = $("#site-logo-fileid").attr("fileId");
            showSiteLogo(fileId)
        });

        function updateDataValue() {

            var key = $("#updatePopupButton").attr("key-value");

            var url = "index.php?action=manage.config.update&key=" + key;

            var value = $.trim($(".popup-group-input").val());

            var data = {
                'key': key,
                'value': value,
            };

            zalyjsCommonAjaxPostJson(url, data, updateConfigResponse);

            // close
            removeWindow($(".config-hidden"));
        }

        function updateConfigResponse(url, data, result) {
            var res = JSON.parse(result);
            if ("success" == res.errCode) {
                window.location.reload();
            } else {
                alert("error:" + result.errInfo);
            }
        }

        $(document).on("click", "#site-name", function () {
            var title = $(this).find(".item-body-desc").html();
            var inputBody = $(this).find(".item-body-value").html();

            showWindow($(".config-hidden"));

            $(".popup-group-title").html(title);
            $(".popup-group-input").val(inputBody);
            $("#updatePopupButton").attr("key-value", "name");
        });

        $(document).on("click", "#group-max-members", function () {
            var title = $(this).find(".item-body-desc").html();
            var inputBody = $(this).find(".item-body-value").html();

            showWindow($(".config-hidden"));

            $(".popup-group-title").html(title);
            $(".popup-group-input").val(inputBody);
            $("#updatePopupButton").attr("key-value", "maxGroupMembers");
        });


        $(document).on("click", "#web-ws-port", function () {
            var title = $(this).find(".item-body-desc").html();
            var inputBody = $(this).find(".item-body-value").html();

            showWindow($(".config-hidden"));

            $(".popup-group-title").html(title);
            $(".popup-group-input").val(inputBody);
            $("#updatePopupButton").attr("key-value", "wsPort");
        });

        //enable realName
        $("#enableRealNameSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableRealName";

            var data = {
                'key': 'enableRealName',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableRealNameResponse);

        });

        function enableRealNameResponse(url, data, result) {
            alert(result);
        }


        //update uic
        $("#enableUicSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableInvitationCode";

            var data = {
                'key': 'enableInvitationCode',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableUicResponse);

        });

        function enableUicResponse(url, data, result) {
            alert(result);
        }


        //enable add friend
        $("#enableAddFriendSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableAddFriend";

            var data = {
                'key': 'enableAddFriend',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableAddFriendResponse);
        });

        function enableAddFriendResponse(url, data, result) {
            alert(result);
        }

        //enable tmp chat
        $("#enableTmpChatSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableTmpChat";

            var data = {
                'key': 'enableTmpChat',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableTmpChatResponse);
        });

        function enableTmpChatResponse(url, data, result) {
            alert(result);
        }

        //enable create group
        $("#enableCreateGroupSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableCreateGroup";

            var data = {
                'key': 'enableCreateGroup',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableCreateGroupResponse);
        });

        function enableCreateGroupResponse(url, data, result) {
            alert(result);
        }

        //enable share group chat
        $("#enableShareGroupSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableShareGroup";

            var data = {
                'key': 'enableShareGroup',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableShareGroupResponse);
        });

        function enableShareGroupResponse(url, data, result) {
            alert(result);
        }

        //enable share user
        $("#enableShareUserSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=enableShareUser";

            var data = {
                'key': 'enableShareUser',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableShareUserResponse);
        });

        function enableShareUserResponse(url, data, result) {
            alert(result);
        }

        $("#enableAddFriendSwitch").change(function () {
            var isChecked = $(this).is(':checked')
            var url = "index.php?action=manage.config.update&key=enableAddFriend";

            var data = {
                'key': 'enableAddFriend',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableAddFriendResponse);
        });

        function enableAddFriendResponse(url, data, result) {
            alert(result);
        }


        //open web edition
        $("#openWebEditionSwitch").change(function () {
            var isChecked = $(this).is(':checked');
            var url = "index.php?action=manage.config.update&key=openWebEdition";

            var data = {
                'key': 'openWebEdition',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, updateOpenWebResponse);

        });

        function updateOpenWebResponse(url, data, result) {

            var res = JSON.parse(result);
            if (res.errCode) {
                alert("update success");
                //判断当前开关

                var openWebIsChecked = $("#openWebEditionSwitch").is(':checked');

                if (openWebIsChecked) {
                    $("#web-ws-port").show();
                } else {
                    $("#web-ws-port").hide();
                }

            } else {
                alert("update error");
                // window.location.reload();
            }

        }

        //open web widgit
        $("#enableWebWidgetSwitch").change(function () {
            var isChecked = $(this).is(':checked')
            var url = "index.php?action=manage.config.update&key=enableWebWidget";

            var data = {
                'key': 'enableWebWidget',
                'value': isChecked ? 1 : 0,
            };

            zalyjsCommonAjaxPostJson(url, data, enableWebWidgetResponse);
        });

        function enableWebWidgetResponse(url, data, result) {
            alert(result);
        }

        //site managers
        $("#site-managers").click(function () {
            var url = "index.php?action=manage.config.siteManagers&lang=" + getLanguage();
            zalyjsCommonOpenPage(url);
        });

        //site default friend
        $("#site-default-friends").click(function () {
            var url = "index.php?action=manage.config.defaultFriends&lang=" + getLanguage();
            zalyjsCommonOpenPage(url);
        });

        //site default groups
        $("#site-default-groups").click(function () {
            var url = "index.php?action=manage.config.defaultGroups&lang=" + getLanguage();
            zalyjsCommonOpenPage(url);
        });

        //site RSAPublicKeyPem
        $("#site-rsa-pubk-pem").click(function () {
            var url = "index.php?action=manage.config.pubk&lang=" + getLanguage();

            alert("url=" + url);
            zalyjsCommonOpenPage(url);
        });

        //site owner
        $("#site-owner").click(function () {
            var userId = $(this).attr("siteOwner");
            var url = "index.php?action=manage.user.profile&lang=" + getLanguage() + "&userId=" + userId;
            zalyjsCommonOpenPage(url);
        });


        //push 推送 类型
        $(document).on("click", '#push-notice-type', function () {
            var language = getLanguage();

            /**
             * 0:禁止推送
             * 1:只推送通知
             * 2:推送文本
             */
            $.actions({
                title: "",
                onClose: function () {
                    console.log("close");
                },
                actions: [{
                    text: language == 0 ? "Show Content" : "显示文本内容",
                    className: "color-primary weui-dialog__btn",
                    onClick: function () {
                        $("#push-notice-type-text").html(language == 0 ? "Show Content" : "显示文本内容");
                        $("#push-notice-type").attr("data", "2");
                        updatePushNoticeType(2);
                    }
                }, {
                    text: language == 0 ? "Hide Content" : "不显示文本内容",
                    className: "color-primary weui-dialog__btn",
                    onClick: function () {
                        $("#push-notice-type-text").html(language == 0 ? "Hide Content" : "不显示文本内容");
                        $("#push-notice-type").attr("data", "1");
                        updatePushNoticeType(1);
                    }
                }, {
                    text: language == 0 ? "Push Disable" : "禁止推送通知",
                    className: "color-primary weui-dialog__btn",
                    onClick: function () {
                        $("#push-notice-type-text").html(language == 0 ? "Push Disable" : "禁止推送通知");
                        $("#push-notice-type").attr("data", "0");

                        updatePushNoticeType(0);
                    }
                }]
            });
        });

        //update push notice type
        function updatePushNoticeType(pushTypeValue) {
            var url = "index.php?action=manage.config.update";

            var data = {
                'key': 'pushType',
                'value': pushTypeValue,
            };

            zalyjsCommonAjaxPostJson(url, data, updatePushTypeResponse);
        }


        function updatePushTypeResponse(url, data, result) {
            alert(result);
            alert(url);
            alert(data.key);
        }

    </script>


</body>
</html>




