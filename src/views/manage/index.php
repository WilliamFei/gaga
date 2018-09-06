<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Site Manage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
            display: flex;
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            flex-shrink: 0;

        }

        .item-row {
            background: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 50px;
            /*margin-bottom: 2rem;*/
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

        .item-body {
            width: 100%;
            height: 50px;
            margin-left: 1rem;
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
            line-height: 3rem;
        }

        .item-body-tail {
            margin-right: 10px;
        }

        .item-body-desc {
            height: 3rem;
            font-size: 16px;
            font-family: PingFangSC-Regular;
            /*color: rgba(76, 59, 177, 1);*/
            margin-left: 11px;
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

            <div class="item-row" id="site-config-id">
                <div class="item-header">
                    <img class="site-manage-image"
                         src="data:image/png;base64,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"/>
                </div>
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">站点设置</div>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <div class="item-row" id="mini-program-id">
                <div class="item-header">
                    <img class="site-manage-image"
                         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAQCElEQVR4Xu2daZBVRxmGn54ZGHaGsA47BEiIIQkRS+Nu4m4lRmNQYrmlXMvtn5ZVUkIqpUb/+MMSY6lYUbNJ0BgTy90sxrgyLJIQ9iXAQFhmGGBgZm5bb05umDn33Ln33Hv6LFOnqyiq5t7T3ed7b3/99be8bSjTVlnbZDcwpQGuwXAThsuwzAXGl3sm/3ssEujEsM9YtmJ4oNDNk61NtH9qmekJGt2U/NFac1sby6xhBZYbgTlAQyxTzwcJKwELHMSw3hS4Z+VSnjLG6G8vtQEAr7K2oXEjNxYs3wQuzoENK+/Evl/AsNdYvr75Ktb+wpi+4kxeAljgNmxiuS1wJzAusanmA9cjgdPW8AWu5CerjCmoIw9ga83qNm7BsAbL2HpGyJ9NWAKGLgNfXHkla6WuXwD4a5vtFQ29rAMWJjy9fPhoJHBANtSqq8wTRtZyw0ZWWstX8z03Gukm3ouhYCw/PjqGz5nb2+yMPngMy/zEJ5ZPIDoJGJ5r6OE6s/q/Vmfc+/PVG51sU9GToYDlVrN6g70bWJGKSeWTiFQCxrLerG6zm7AsibTnvLN0SMCwVSv4ZO5+TAceDmbRKYAHuLYcDJJ3maAEcoATFH4cQ+cAxyHlBMfIAU5Q+HEMnQMch5QTHCMHOEHhxzF0DnAcUk5wjBzgBIUfx9A5wHFIOcExhiTACnI3N8KYJlg0DmaPgXHDoGW4l+HQ0QMnz8OB0/BsJ3T2wLk+GIoenyEHsIBcMsEDdspID+jBWk8B2s/C9g7430k4fj7B5eZg6CEF8KXj4fVTYdIIaAqZB9pXgOPn4PF22CLv/BBpQwLgJgOvnAzXtoIpTQQOBZU884+1w9+PwPkX0tay3TIP8LAGeNM0WDYp/KotB12fhc3H4fcHofulBNRsAp15gF8zBV4/DQR0lK23AH87Ao8ejrLX+PvKNMDac2+eG6yWpWq1EjvPw9MdsK0DjnaDtO74YTBnDCxugdaRMKKxfB/r93rGV1ZbZgGWtbxiPkwdGSz6k+fgH0dh8wk4U0bNatHPHO3t3/qxBO3fJ87B3bvg2LlsQpxJgGVHvXwivHVG8L575Cxo5T3/4oqtBM3IRrhmMrxmainI0gJPtsNfD2fznJxJgKVSpZrn+WowpJblxLh3JxwJueKGN8ANszy17V/Jh87APbugq7fSTyV9n2cS4Mkj4NaFpU4MOS3+dBD+9Xxtq23mKFg+D8YMGwiU+v3pDjhwJn0AVppRJgF+9WR484zSV5NK/tGzcK7G86v25JvnwSUBFdCPHoJH2yuJM32fZxLgD8yDRY5AWHoRXD+7FKgdnZ6xlbWWSYA/tQimjioV9Q+3wcGz9UEwsRk+u7i0j6NnYc22+vpO4ulMAvyly2FEU6m47thUu3ou9iaHyVeuKO37XC/csSUJiOobM5UAay+cMBze0Aq/ew5O+6zXL18OzQEAf2MTyCCqp5UFuA/u2DywZx2v3jwdnjwCOi/XOXQ90y77bOoA1nHl6onwqsmeh+m3B2DjiYHzL6ei1zwNR0Mej/ySCaOiF4yF98zxPGb/POpZ77UaeE7QVYV/miobmhs8gc0dA8MbRTwAG4/DIwegt180vpyR9fB++M+x+kR15QR4t2hnfG1nJ/y8n5ElZ4v84G9q9b6o+e3qhF/uS1cUKjUAy/UocOUj7t9k3EiwyroottdOgWunl4Kw6xTcvbN2VSnQ5EC5tKW078cPw1/6BR6kXW6aAxf72EyUJfLAHs/hkoaWCoAnN8PbZsDcsdDgi+dK/a3bDds6L4irnKNDob31e2DHqdpEG8bRIfX8vrmepunfpHX2n/a2lvbu2uYR5VOJAzy6ET54sRc0KBesf/ok/GLPhdfW6nn/vNLVLuEK3F/thbMh47ja+981Ey6fUDqPw3JV7oZT/Vblhxd4W0lQ0zyOdMPPdpYaiFGCV01fiQKsfKn3Bai54sQlKO1typdat/fC62iRv2ISvGU6NPriwHrmb+3wRIiMDIEro+4N00rBLVgvu+PPhwa6P1uGwQ2zvYQ+v9YpznR/F9y3u3w0qxqA6v1OYgArzUYGioAqlz/Vcd47grQdgx5fyuNg4UKBvL0T/vk87O3yrNygVm24UDaA8rX8bXSTF4V65RRoDEgVKmaG6KiXlHWdGMCLx8O7Z5fuYUUhKp67bg8cPlveaLq8xTPMglS7QD7T6wUInu3w9sWi4TN2GMwa5fmcZ4z20mvL9fHrfaXHtP5ADzOwdKJ3Hg76oepcrv247Xi9a7G25xMBWAL99KUwKsBZIWCUeaE9t5ogu9SqrGq/qq5NHBee0up76gj86VDlnqQJpOLf2BoM8tle+MG2ZCzr2AHWWVd7l+KuQe14Nzy431tx1bS0JN3pva5rhWWTg2e9+xQ8sNfTKnG22AEeTDWrukDn2P0h464S7quUfBeQkRFWmNIg2vf1L6wlrnm8dw4sDIh0KYlPhtpTR8POqL7vxwqwrFXtu0GrV4nnv9k/+H5X6VVf1uKl0I5vDjZ6Bnte1rIS9JRF6XeNVhq3/+cqj/nIAhg/vPQpaaX7d8d7dIoV4IvHehkT/hRXrRqddR/aX7+1qYxJnWVrKl3pCLaWwwCs/fjlkzyjy/+e+hH/er+XCBhXixXgjy+C6QFxXO1L9+0Kr5rLCUknFh1htIrkcZKlrGOVwFf1mVaqXJ8Hz3iOERWidfXUluYTNIdRjfChBcEZn8e6Yc0ztbtTw/4wYgN44VhYIYrxgLbhmLd6h1K7+iJ416zg45fcqXHVP8UCsFaUPFaLJ5RCqNX0o+0D3YBDAWg5crQXS3v4m5wvcmOWc8BE+f6xAHxRM3xwPkxoLp36Y4e9nOOh2OSIea+uMfE1bUlKw30u5GmhFhnFArCMnutnlRodOhat3e455odik0PnYwtLf9haucrSlL/cdXMOsHy0cgDonOpvCqKrAiHsedO1UKLqX2paYVBZ1f629SQ8uK/+FKNKc3UOsEJ7ipvOD6hCUJTmj1W4Aiu9RJo/V4nN22eWnsuDQpAu3sM5wDqefGIRjPZVC5zvg4cPxHsmdCHASn0qZqwfuN/vruQEbU/yu7tszgGWc+OW+aXHhdM9cNeO+pPkXAonir519taZWIamvym1x3VpqnOAy+VPKdb7vadL47xRCDVNfcgGkYMnqMz1iXbPP+2yOQdYFXtXTSx9BWU7rN3h8tXS0/eKecEBiC0nPCPTZXMO8K0LYOYY0J6r/ebEeZB6ViDetXpyKbgwfS8UV9dobx9W3vXUEV7ivlylP3w2TE/hv+sc4I8uAMVCRTim+loBrTyrOLw44cXh7gl585TxoZCi/OQ6VQj4u3a6G1M9OwfY7fTz3itJIAe4koQy/nkOcMYBrDT9RABWUFweLsVrL2uBaSNh3HAvXqssRGU/qlpv5ynY3QVKWksr61zaiU9jB1hlJyrwUk2PLMrBOCWV6SE/taIuW094uc7lKJEq/ZJdfJ4F4tNYAVaSuBzvylsqVw1QDghZ34fOevXCypVOumWF+DQWgHU0UJnJ1QFRlbBAyYer2iOp7ySOWlkjPnUOsPbad8yAyyaEz3QcbDUXU1v71w2H/bGE/X5acrDDzNs5wO+c4ZV2RF15oGQBFXzHldskoWaR+NQpwMsmwjtnBf/eigbUvi54psMzpJSfpazHaslCe/o8T1AcqS9ZJT51BrAsZJGFBoXJlB+sYixlU8pwKndXQjXVf/Ln3uuYZjDLxKdOANbZUMVYolnwl1UK3D8chA3Hq09XGYwsVCUhfzkEf3dUEpJ14lMnAAsQrV5R9fZvUssKkSmTI6zjYjCyUKn5+/e4KezKOvGpE4AV3BZZqL90Q2HCe3fXvmeW49CQwaXsEKn7qFvWiU+dAPw60QsFsOA8c9Ir6q6VMKwcWag0g+p4dXSKumWd+NQJwOUyGB7cW1/lnsArRxaqKn5ph6hb1olPnQD86Uu8S6n87btb6794qhwTnS63utMBWWjWiU+dAFyOLPQbG+tPsivHJdndC99yQBaadeLTeAF2SBYqH/W3fGShUajrtBCf1vouTgD+5CKYFlAH7JIsNG4V7fJdouSmdgJwEmShIksTG13ULYl38ROf1vNOTgCWU/66GMlCdUySN8tFtV4aiE9TB3DcZKFJODriJD5NHcBy74lsxU/W6Yos1CV7TRqIT1MHsBz0ChXqZjLXZKEKXoghQBdJumhpID6t572c7MGaUFxkoUmHC+MiPq0VZGcAa0IvG+9xVLgiC1WKrZjx9lZJe1irkPRcGohPa5m/U4A1oddN9f6FvXK90ssI3EfqZMarNIb/8zQQn4ads3OAXSSqKYU2T7qrDmrnAGsaUZKFFpPtdIdDvXckVSeigd+K8l3qIT6tdu6xAFycjOiU3jittsR3peaovljZIDKsim3OaC+ZXnxbqj2uJ1daFrOORTrHixVoy3HY2hEsyjQQn1YDcqwAa0KqR1oyAS4ZB5NHglJxyrVKpSvivRSDXkuzV1Su7Mw9XbDvdDjmPBVmq6/Zo7w7iVtHeZUXqokSA66uiA9qSROfphJgTUorRXf0qoRFrLASrmj2dbRSIrvSZ0UQKrD0T7ed+Lm0dPXdTXMHkpvqB6G7EQS2gg9K4dHlzlrZUu3dBS8JUAXYY5u8mLWcMfpff9Pq9ZfUiEtElRTlLPWkiU8rgRz7Cq40oWo+FxAiGLsi4Aqcap4P+x1xS4pA9FTMbO1h5xn0/UwCrJwvXVwZtoCtVoEVjaFq7m+odQxXz2US4EnNcM0Uby+P+nztF7SMtm0n4fH2dNxkFvaHkEmAiy+p/fPaVq/OWJdsRbWiRe+vPVu3vojiX5WMWW2ZBlhC19WBsnp1A9ms0dA60jPgwoKtoIUMKtUe61IQXTIpI01gZ7llHuD+wldFxcgXLWTRQgj4i4Z7t4Vrhcs4U9PxR5zNssxlrRfBVIxXyXuytodKG1IADxVQonyPHOAopZnCvnKAUwhKlFPKAY5SminsKwc4haBEOaUc4CilmcK+BLBiJeNSOLd8SvVLoNOsbrObsCypv6+8h9RJwLDV3LbB3mdheeoml0+obgkY+JW5rc0ut5Z7XwzT1t1p3kFqJGCN4ePm9jY7ow8ewzI/NVPLJ1K/BAzPNfRwnbnz33bY4UZWA18GBkmgqX/MvIeYJGAoGMtdhRY+o4wTVv3bXm2aWIdlXkxTyIdxKQHLYWtYsWqp+esLAGOtWd3GLRjWYPFdQudyJnnfkUvA0GXgiyuvZK0xxnoAAzdb27hkCx+xvXwHcpAjF3w8HZ6hkS8tXsL3lxvTpyFfAvgFVW1tQ8MmltsC38YwHZvvyfHgUucohgIFjmC4ffFVF8AtAbiorm9rY5l0OJYbgTm58VUnAO4eV77JQQzrTYF7Vi7lKanl/sMNWMH9P/j8dts8pYvZBXi1sdxgG7gEi8iBc7emO8Aq92w4heGAKbANw0OFXp5kIntWzTOB95j+Hy5InORB0PXTAAAAAElFTkSuQmCC"/>
                </div>
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">小程序管理</div>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <div class="item-row" id="user-manage-id">
                <div class="item-header">
                    <img class="site-manage-image"
                         src="data:image/png;base64,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"/>
                </div>
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">用户管理</div>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="group-manage-id">
                <div class="item-header">
                    <img class="site-manage-image"
                         src="data:image/png;base64,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"/>
                </div>
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">群组管理</div>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="uic-manage-id">
                <div class="item-header">
                    <img class="site-manage-image"
                         src="data:image/png;base64,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"/>
                </div>
                <div class="item-body">
                    <div class="item-body-display">
                        <div class="item-body-desc">邀请码</div>

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
<!--<script src="../../public/js/im/zalyjsNative.js"></script>-->
<!---->
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

    function isMobile() {
        if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
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

    function getLanguage() {
        var nl = navigator.language;
        if ("zh-cn" == nl || "zh-CN" == nl) {
            return 1;
        }
        return 0;
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
    function zalyjsCommonOpenPage(url) {
        location.href = url;
    }

    $("#site-config-id").click(function () {
        var url = "/index.php?action=manage.config&lang=" + getLanguage();
        zalyjsCommonOpenPage(url);
    });

    $("#mini-program-id").click(function () {
        var url = "index.php?action=manage.miniProgram&lang=" + getLanguage();
        // alert("url=" + url);
        zalyjsCommonOpenPage(url);
    });

    $("#user-manage-id").click(function () {
        var url = "index.php?action=manage.user&lang=" + getLanguage();
        zalyjsCommonOpenPage(url);
    });

    $("#group-manage-id").click(function () {
        var url = "index.php?action=manage.group&lang=" + getLanguage();
        zalyjsCommonOpenPage(url);
    });

    $("#uic-manage-id").click(function () {
        var url = "index.php?action=manage.uic&page=index&lang=" + getLanguage();
        zalyjsCommonOpenPage(url);
    });

    $("#data-report-id").click(function () {
        var url = "index.php?action=manage.dataReport";
        // alert("url=" + url);
        zalyjsCommonOpenPage(url);
    });

</script>

</body>
</html>




