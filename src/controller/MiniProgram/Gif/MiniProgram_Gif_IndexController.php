<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 05/09/2018
 * Time: 2:27 PM
 */

class MiniProgram_Gif_IndexController extends  MiniProgramController
{

    private $gifPluginId = 106;
    private $action = "duckChat.message.send";
    private $groupType = "g";
    private $u2Type = "u";

    public function getMiniProgramId()
    {
        // TODO: Implement getMiniProgramId() method.
        return $this->gifPluginId;
    }

    public function doRequest()
    {
        header('Access-Control-Allow-Origin: *');
        $method = $_SERVER['REQUEST_METHOD'];
        $tag = __CLASS__ ."-".__FUNCTION__;
        if ($method == 'POST') {
            $this->ctx->Wpf_Logger->error($tag, "post msg =" . json_encode($_POST));
            $message = $_POST;
            $this->sendMessage($message);
        } else {
            $pageUrl = $_COOKIE['duckchat_page_url'];
            $pageUrl = parse_url($pageUrl);
             parse_str($pageUrl['query'], $queries);
            $x = $queries['x'];
            list($type, $toId) = explode("-", $x);
            if($toId == $this->userId) {
                return;
            }

            if($type == $this->groupType) {
                $roomType = "MessageRoomGroup";
            }elseif($type == $this->u2Type) {
                $roomType = "MessageRoomU2";
            }

            $params = [
                "roomType" => $roomType,
                "toId" => $toId,
                "fromUserId" => $this->userId,
            ];

            $params['gifs'] = [
                [
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],
                [
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],
                [
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],
                [
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],
                [
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],[
                    "url" => "https://media.giphy.com/media/NWLUwtaivTes8/200w_d.gif",
                    "width" => 200,
                    "height" => 200
                ],
            ];
            $params['gifs'] = json_encode($params['gifs']);
            echo $this->display("miniProgram_gif_index", $params);
            return;
        }
    }
    private function sendMessage($msg)
    {

        $this->ctx->Wpf_Logger->error("api.site.login", "get profile from platform msg =" . json_encode($msg));
        $msgReqData = [
            "action" => "duckChat.message.send",
            "body" => [
                "@type" => "type.googleapis.com/plugin.DuckChatMessageSendRequest",
                "message" => $msg['message']
            ]
        ];

        $msgDataJsonStr = json_encode($msgReqData);
        $siteAddress = ZalyConfig::getConfig("siteAddress");
        $sendMsgUrl = $siteAddress."/index.php?action=".$this->action."&body_format=json&miniProgramId=".$this->gifPluginId;
        $this->ctx->Wpf_Logger->error("api.site.login", "get profile from platform url=" . $sendMsgUrl);
        $this->ctx->Wpf_Logger->error("api.site.login", "get profile from platform msgData =" . $msgDataJsonStr);

        $result = $this->ctx->ZalyCurl->request("post", $sendMsgUrl, $msgDataJsonStr);

    }
}