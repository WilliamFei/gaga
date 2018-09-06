<?php
/**
 *
 * cts Message && proxy Message
 *
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 31/07/2018
 * Time: 6:45 PM
 */

class Message_Client
{

    private $ctx;

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
    }

    /**
     * @param string $msgId
     * @param $userId
     * @param string $fromUserId
     * @param string $toUserId
     * @param int $msgType
     * @param \Zaly\Proto\Core\Message $message
     * @param int $roomType
     * @return bool
     */
    public function sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message, $roomType = Zaly\Proto\Core\MessageRoomType::MessageRoomU2)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        $result = false;

        switch ($msgType) {
            case \Zaly\Proto\Core\MessageType::MessageNotice:
                $notice = $message->getNotice();
                $noticeBody = $notice->getBody();
                //# TODO limit body length 2KB = 2048 Byte
                $noticeBody = substr($noticeBody, 0, 2048);
                $notice->setBody($noticeBody);
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $notice, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageText:
                $text = $message->getText();
                $textBody = $text->getBody();
                //# TODO limit body length 2KB = 2048 Byte
                $textBody = substr($textBody, 0, 2048);
                $text->setBody($textBody);
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $text, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageImage:
                $image = $message->getImage();
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $image, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageAudio:
                $audio = $message->getAudio();
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $audio, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageWeb:
                $web = $message->getWeb();
                $webCode = $web->getCode();
                $webCode = substr($webCode, 0, 10240);
                //# TODO limit body length 2KB = 2048 Byte
                $web->setCode($webCode);
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $web, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageWebNotice:
                $webNotice = $message->getWebNotice();
                $webNoticeBody = $webNotice->getCode();
                //# TODO limit body length 2KB = 2048 Byte
                $webNoticeBody = substr($webNoticeBody, 0, 10240);
                $webNotice->setCode($webNoticeBody);
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $webNotice, $roomType);
                break;
            case \Zaly\Proto\Core\MessageType::MessageEventFriendRequest:
                $result = $this->saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, null, $roomType);
                break;
            default:
                $this->ctx->Wpf_Logger->error("u2-message", "unsupport message type");
                break;

        }

//        $this->tellClientNews(false, $toUserId);

        return $result;
    }

    /**
     * @param string $msgId
     * @param string $fromUserId
     * @param string $groupId
     * @param int $msgType
     * @param \Zaly\Proto\Core\Message $message
     * @return bool
     */
    public function sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message)
    {
        $tag = __CLASS__ . "->" > __FUNCTION__;
        $result = false;
        switch ($msgType) {
            case \Zaly\Proto\Core\MessageType::MessageNotice:
                $notice = $message->getNotice();
                $noticeBody = $notice->getBody();
                //# TODO limit body length 2KB = 2048 Byte
                $noticeBody = substr($noticeBody, 0, 2048);
                $notice->setBody(trim($noticeBody));
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $notice);
                break;
            case \Zaly\Proto\Core\MessageType::MessageText:
                $text = $message->getText();
                $textBody = $text->getBody();
                //# TODO limit body length 2KB = 2048 Byte
                $textBody = substr($textBody, 0, 2048);
                $text->setBody(trim($textBody));
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $text);
                break;
            case \Zaly\Proto\Core\MessageType::MessageImage:
                $image = $message->getImage();
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $image);
                break;
            case \Zaly\Proto\Core\MessageType::MessageAudio:
                $audio = $message->getAudio();
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $audio);
                break;
            case \Zaly\Proto\Core\MessageType::MessageWeb:
                $web = $message->getWeb();
                $webCode = $web->getCode();
                ////# TODO limit body length 1B <= size <= 1M
                $webCode = substr($webCode, 0, 10240);
                $web->setCode($webCode);
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $web);
                break;
            case \Zaly\Proto\Core\MessageType::MessageWebNotice:
                $webNotice = $message->getWebNotice();
                $webNoticeCode = $webNotice->getCode();
                ////# TODO limit body length 1B <= size <= 1M
                $webNoticeCode = substr($webNoticeCode, 0, 10240);
                $webNotice->setCode($webNoticeCode);
                $result = $this->saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $webNotice);
                break;
            default:
                $this->ctx->Wpf_Logger->error($tag, "do error group Message with unsupport msgType=" . $msgType);
                break;

        }

//        $this->tellClientNews(true, $groupId);

        return $result;
    }

    /**
     * @param $msgId
     * @param $userId
     * @param $fromUserId
     * @param $toUserId
     * @param $msgType
     * @param Google\Protobuf\Internal\Message $content
     * @param int $roomType
     * @return bool
     */
    private function saveU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $content, $roomType = Zaly\Proto\Core\MessageRoomType::MessageRoomU2)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;

        try {
            $u2Message = [
                "msgId" => $msgId,
                "userId" => $userId,
                "fromUserId" => $fromUserId,
                "toUserId" => $toUserId,
                "roomType" => $roomType,
                "msgType" => $msgType,
                "content" => empty($content) ? "" : $content->serializeToJsonString(),
                "msgTime" => $this->ctx->ZalyHelper->getMsectime()
            ];
            //入库
            return $this->ctx->SiteU2MessageTable->insertMessage($u2Message);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }

        return false;
    }

    /**
     * @param string $msgId
     * @param string $fromUserId
     * @param string $groupId
     * @param int $msgType
     * @param Google\Protobuf\Internal\Message $content
     * @return bool
     */
    private function saveGroupMessage($msgId, $fromUserId, $groupId, $msgType, $content)
    {
        $tag = __CLASS__ . "." . __FUNCTION__;
        try {
            $groupMessage = [
                "msgId" => $msgId,
                "groupId" => $groupId,
                "fromUserId" => $fromUserId,
                "msgType" => $msgType,
                "content" => $content->serializeToJsonString(),
                "msgTime" => $this->ctx->ZalyHelper->getMsectime()
            ];

            return $this->ctx->SiteGroupMessageTable->insertMessage($groupMessage);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e->getMessage());
        }
        return false;
    }

    /**
     * build a u2 msgId
     *
     * @param $userId
     * @return string
     */
    private function buildU2MsgId($userId)
    {
        $timeMillis = $this->ctx->ZalyHelper->getMsectime();
        $msgId = "U2-" . substr($userId, 0, 8) . "-" . $timeMillis;
        return $msgId;
    }

    /**
     * build a group msgId
     *
     * @param $userId
     * @return string
     */
    private function buildGroupMsgId($userId)
    {
        $timeMillis = $this->ctx->ZalyHelper->getMsectime();
        $msgId = "GP-";
        if (!empty($userId)) {
            $msgId .= substr($userId, 0, 8);
        } else {
            $randomStr = $this->ctx->ZalyHelper->generateStrKey(8);
            $msgId .= $randomStr;
        }
        $msgId .= "-" . $timeMillis;
        return $msgId;
    }

    /**
     * get current timestamp millis
     * @return mixed
     */
    private function getCurrentTimeMills()
    {
        return $this->ctx->ZalyHelper->getMsectime();
    }

    /**  proxy message **/

    /**
     * proxy send u2 notice message
     *
     * @param string $userId ,who will receive this message
     * @param string $fromUserId , who send this message
     * @param $toUserId , if $userId!=$toUserId, means maybe user proxy send to self
     * @param $noticeText
     * @return bool
     */
    public function proxyU2NoticeMessage($userId, $fromUserId, $toUserId, $noticeText)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageNotice;
            $msgId = $this->buildU2MsgId($fromUserId);

            $notice = new Zaly\Proto\Core\NoticeMessage();
            $notice->setBody($noticeText);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setNotice($notice);
            $message->setTimeServer($this->getCurrentTimeMills());

            $request = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);

            $this->ctx->Message_News->tellClientNews(false, $toUserId);

            return $request;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send u2 text message
     *
     * @param string $userId
     * @param string $fromUserId
     * @param string $toUserId
     * @param string $text
     * @return bool
     */
    public function proxyU2TextMessage($userId, $fromUserId, $toUserId, $text)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageText;
            $msgId = $this->buildU2MsgId($fromUserId);

            $textMsg = new Zaly\Proto\Core\TextMessage();
            $textMsg->setBody($text);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setText($textMsg);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);

            $this->ctx->Message_News->tellClientNews(false, $toUserId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send u2 image message
     *
     * @param $userId
     * @param $fromUserId
     * @param $toUserId
     * @param $url
     * @param $width
     * @param $height
     * @return bool
     */
    public function proxyU2ImageMessage($userId, $fromUserId, $toUserId, $url, $width, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageImage;
            $msgId = $this->buildU2MsgId($fromUserId);

            $image = new Zaly\Proto\Core\ImageMessage();
            $image->setUrl($url);
            $image->setWidth($width);
            $image->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setImage($image);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(false, $toUserId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send u2 web message
     *
     * @param $userId
     * @param $fromUserId
     * @param $toUserId
     * @param $title
     * @param $code
     * @param $hrefUrl
     * @param $width
     * @param $height
     * @return bool
     */
    public function proxyU2WebMessage($userId, $fromUserId, $toUserId, $title, $code, $hrefUrl, $width, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageWeb;
            $msgId = $this->buildU2MsgId($fromUserId);

            $web = new Zaly\Proto\Core\WebMessage();
            if ($title) {
                $web->setTitle($title);
            }
            if (!empty($code)) {
                $web->setCode($code);
            } else {
                $web->setHrefURL($hrefUrl);
            }
            $web->setWidth($width);
            $web->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setWeb($web);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(false, $toUserId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send u2 web notice message
     *
     * @param $userId
     * @param $fromUserId
     * @param $toUserId
     * @param $title
     * @param $code
     * @param $hrefUrl
     * @param $height
     * @return bool
     */
    public function proxyU2WebNoticeMessage($userId, $fromUserId, $toUserId, $title, $code, $hrefUrl, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageWebNotice;
            $msgId = $this->buildU2MsgId($fromUserId);

            $webNotice = new Zaly\Proto\Core\WebNoticeMessage();
            if ($title) {
                $webNotice->setTitle($title);
            }
            if (!empty($code)) {
                $webNotice->setCode($code);
            } else {
                $webNotice->setHrefURL($hrefUrl);
            }
            $webNotice->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setWebNotice($webNotice);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);

            $this->ctx->Message_News->tellClientNews(false, $toUserId);

            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }


    public function proxyNewFriendApplyMessage($userId, $fromUserId, $toUserId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageEventFriendRequest;
            $msgId = $this->buildU2MsgId($fromUserId);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setTimeServer($this->getCurrentTimeMills());

            $this->ctx->Wpf_Logger->info("friendApplyEvent =======>", "message=" . $message->serializeToString());

            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $toUserId, $msgType, $message);

            $this->ctx->Wpf_Logger->info("friendApplyEvent =======>", "result=" . $result);

            $this->ctx->Message_News->tellClientNews(false, $toUserId);

            $fromNickName = $this->ctx->SiteUserTable->getUserNickName($fromUserId);
            $pushText = 'You have a friend apply';
            if ($fromNickName) {
                $pushText = $fromNickName . " apply to you as a friend";
            }
            $msgRoomType = \Zaly\Proto\Platform\PushRoomType::PushRoomU2;
            $this->ctx->Push_Client->sendNotification($msgRoomType, $msgType, $fromUserId, $toUserId, $pushText);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }



    //==========================proxy group message=========================

    /**
     * proxy send group notice message
     *
     * @param string $fromUserId
     * @param string $groupId
     * @param string $noticeText
     * @return bool
     */
    public function proxyGroupNoticeMessage($fromUserId, $groupId, $noticeText)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {

            $msgType = Zaly\Proto\Core\MessageType::MessageNotice;
            $msgId = $this->buildGroupMsgId($fromUserId);
            $notice = new Zaly\Proto\Core\NoticeMessage();
            $notice->setBody($noticeText);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setNotice($notice);
            $message->setTimeServer($this->getCurrentTimeMills());


            $result = $this->sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message);

            $this->ctx->Message_News->tellClientNews(true, $groupId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy group notice but save in U2
     *
     * @param $userId
     * @param $fromUserId
     * @param $groupId
     * @param $noticeText
     * @return bool
     */
    public function proxyGroupAsU2NoticeMessage($userId, $fromUserId, $groupId, $noticeText)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {

            $msgType = Zaly\Proto\Core\MessageType::MessageNotice;
            $msgId = $this->buildGroupMsgId($fromUserId);
            $notice = new Zaly\Proto\Core\NoticeMessage();
            $notice->setBody($noticeText);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setNotice($notice);
            $message->setTimeServer($this->getCurrentTimeMills());

            $roomType = Zaly\Proto\Core\MessageRoomType::MessageRoomGroup;
            $result = $this->sendU2Message($msgId, $userId, $fromUserId, $groupId, $msgType, $message, $roomType);

            $this->ctx->Message_News->tellClientNews(true, $groupId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }


    /**
     * proxy send group text message
     *
     * @param string $fromUserId
     * @param string $groupId
     * @param string $text
     * @return bool
     */
    public function proxyGroupTextMessage($fromUserId, $groupId, $text)
    {

        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageText;
            $msgId = $this->buildGroupMsgId($fromUserId);

            $textMsg = new Zaly\Proto\Core\TextMessage();
            $textMsg->setBody($text);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setText($textMsg);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(true, $groupId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send group image message
     *
     * @param $fromUserId
     * @param $groupId
     * @param $url
     * @param $width
     * @param $height
     * @return bool
     */
    public function proxyGroupImageMessage($fromUserId, $groupId, $url, $width, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageImage;
            $msgId = $this->buildGroupMsgId($fromUserId);

            $image = new Zaly\Proto\Core\ImageMessage();
            $image->setUrl($url);
            $image->setWidth($width);
            $image->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setImage($image);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(true, $groupId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send group web message
     *
     * @param $fromUserId
     * @param $groupId
     * @param $title
     * @param $code
     * @param $hrefUrl
     * @param $width
     * @param $height
     * @return bool
     */
    public function proxyGroupWebMessage($fromUserId, $groupId, $title, $code, $hrefUrl, $width, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageWeb;
            $msgId = $this->buildGroupMsgId($fromUserId);

            $web = new Zaly\Proto\Core\WebMessage();
            if ($title) {
                $web->setTitle($title);
            }
            if (!empty($code)) {
                $web->setCode($code);
            } else {
                $web->setHrefURL($hrefUrl);
            }
            $web->setWidth($width);
            $web->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setWeb($web);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(true, $groupId);
            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

    /**
     * proxy send group web notice message
     *
     * @param $fromUserId
     * @param $groupId
     * @param $title
     * @param $code
     * @param $hrefUrl
     * @param $height
     * @return bool
     */
    public function proxyGroupWebNoticeMessage($fromUserId, $groupId, $title, $code, $hrefUrl, $height)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $msgType = Zaly\Proto\Core\MessageType::MessageWebNotice;
            $msgId = $this->buildGroupMsgId($fromUserId);

            $webNotice = new Zaly\Proto\Core\WebNoticeMessage();
            if ($title) {
                $webNotice->setTitle($title);
            }
            if (!empty($code)) {
                $webNotice->setCode($code);
            } else {
                $webNotice->setHrefURL($hrefUrl);
            }
            $webNotice->setHeight($height);

            $message = new Zaly\Proto\Core\Message();
            $message->setMsgId($msgId);
            $message->setType($msgType);
            $message->setWebNotice($webNotice);
            $message->setTimeServer($this->getCurrentTimeMills());

            $result = $this->sendGroupMessage($msgId, $fromUserId, $groupId, $msgType, $message);
            $this->ctx->Message_News->tellClientNews(true, $groupId);

            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

}