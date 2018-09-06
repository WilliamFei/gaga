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
            overflow: hidden;
            width: 100%;
            height: 100%;
            background: rgba(245, 244, 249, 1);
            font-size: 10.66px;

        }

        .wrapper {
            width: 100%;
            height: 100%;
            /*display: flex;*/
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            /*display: flex;*/
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
            margin-top: 1rem;
            flex-direction: row;
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
            height: 100%;
            /*line-height: 3rem;*/
        }

        .item-body-tail {
            text-align: center;
            margin-right: 10px;
            font-size: 16px;
            height: 3rem;
            /*color: rgba(76, 59, 177, 1);*/
            line-height: 3rem;
        }

        .item-body-desc {
            height: 3rem;
            font-size: 16px;
            /*color: rgba(76, 59, 177, 1);*/
            margin-left: 10px;
            line-height: 3rem;
        }

        .more-img {
            width: 8px;
            height: 13px;
            /*border-radius: 50%;*/
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

    </style>

</head>

<body>

<div class="wrapper" id="wrapper">

    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Site Name</div>

                        <div class="item-body-tail">
                            192.168.3.4
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: site logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Site Logo</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <!--     part1: group max members      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Group Max Members</div>

                        <div class="item-body-tail">
                            100
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--    part1: message notice       -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Push Notice</div>

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


    <!-- part 2 -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Enable Phone Number</div>

                        <div class="item-body-tail">
                            192.168.3.5555
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: site logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Enable Invite Code</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
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

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Enable Add Friend</div>

                        <div class="item-body-tail">
                            192.168.3.5555
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <!--      part1: site logo      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Enable Tmp Chat</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>

    </div>


    <!--  part4  -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Open Web-Widget</div>

                        <div class="item-body-tail">
                            192.168.3.5555
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Open PC-Web</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Open Mobile-Web</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>

    <!--   part 6 -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Open SSL</div>

                        <div class="item-body-tail">
                            192.168.3.5555
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Open Web Edition</div>

                        <div class="item-body-tail">
                            <img class="site-logo-image" src="../../public/img/manage/program_manage.png"/>
                            <!--                            <img class="more-img" src="../../public/img/manage/more@3x.png"/>-->
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>

    <!--   part 6 -->
    <div class="layout-all-row">

        <div class="list-item-center">

            <!--      part1: site name      -->
            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">Site Public Key</div>

                        <div class="item-body-tail">
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
                        <div class="item-body-desc">Site Manager</div>

                        <div class="item-body-tail">
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
                        <div class="item-body-desc">Site Default Friends</div>

                        <div class="item-body-tail">
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
                        <div class="item-body-desc">Site Default Groups</div>

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
</div>


<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>

<script type="text/javascript">

    var clientType = "";
    var callbackIdParamName = "_zalyjsCallbackId"

    var zalyjsCallbackHelper = function () {
        var thiz = this
        this.dict = {}

        //
        // var id = helper.register(callback)
        //
        this.register = function (callback) {
            var id = Math.random().toString()
            thiz.dict[id] = callback
            return id
        }

        //
        // helper.call({"_zalyjsCallbackId", "args": ["", "", "", ....]  })
        //
        this.callback = function (param) {

            try {

                param = atob(param)
                param = param.replace(/[\r]+/g, "\\r")
                param = param.replace(/[\n]+/g, "\\n")

                var paramObj = JSON.parse(param)

                var id = paramObj[callbackIdParamName]
                var args = paramObj["args"]
                var callback = thiz.dict["" + id]
                console.log("callback: " + param)
                if (callback != undefined) {
                    callback.apply(undefined, args)
                    delete(thiz.dict[id])

                } else {
                    // do log
                }
            } catch (e) {
                // do log
                if (false == isAndroid()) {
                    // window.webkit.messageHandlers.logger.postMessage(typeof(param))

                    window.webkit.messageHandlers.logger.postMessage(param)
                    // window.webkit.messageHandlers.logger.postMessage(atob(param))
                    // window.webkit.messageHandlers.logger.postMessage(e.message)
                } else {
                    console.log("error: " + e.message)
                }
            }
        }
        return this
    }();

    function isAndroid() {

        if (clientType != "" && clientType != null) {
            return clientType.toLowerCase() == "android"
        }

        var userAgent = window.navigator.userAgent.toLowerCase();
        if (userAgent.indexOf("android") != -1) {
            return true;
        }

        return false;
    }

    function jsonToQueryString(json) {
        url = Object.keys(json).map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(json[k])
        }).join('&')
        return url
    }


    //
    //
    // Javascript Bridge Begin
    //
    //

    function zalyjsSetClientType(t) {
        clientType = t
    }

    function zalyjsAjaxGet(url, callback) {
        var callbackId = zalyjsCallbackHelper.register(callback)

        var messageBody = {}
        messageBody["url"] = url
        messageBody[callbackIdParamName] = callbackId
        messageBody = JSON.stringify(messageBody)

        if (isAndroid()) {
            window.Android.zalyjsAjaxGet(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsAjaxGet.postMessage(messageBody)
        }
    }

    function zalyjsAjaxGetJSON(url, param, callback) {
        var queryString = jsonToQueryString(param)
        if (url.indexOf("?") != -1) {
            queryString = "&" + queryString
        } else {
            queryString = "?" + queryString
        }
        url = url + queryString
        zalyjsAjaxGet(url, function (body) {
            var jsonBody = JSON.parse(body)
            callback(jsonBody)
        })
    }

    function zalyjsAjaxPost(url, body, callback) {
        var callbackId = zalyjsCallbackHelper.register(callback)
        var messageBody = {}
        messageBody["url"] = url
        messageBody["body"] = body
        messageBody[callbackIdParamName] = callbackId
        messageBody = JSON.stringify(messageBody)
        if (isAndroid()) {
            window.Android.zalyjsAjaxPost(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsAjaxPost.postMessage(messageBody)
        }
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
        alert("isAndroid=" + isAndroid());
        if (isAndroid()) {
            window.Android.zalyjsNavOpenPage(messageBody)
        } else {
            window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
        }
    }
</script>


</body>
</html>




