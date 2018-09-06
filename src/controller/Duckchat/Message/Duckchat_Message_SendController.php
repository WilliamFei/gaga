<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 04/09/2018
 * Time: 4:27 PM
 */

class Duckchat_Message_SendController extends Duckchat_MiniProgramController
{

    private $classNameForRequest = '\Zaly\Proto\Plugin\DuckChatMessageSendRequest';
    private $classNameForResponse = '\Zaly\Proto\Plugin\DuckChatMessageSendResponse';
    private $requestAction = "duckchat.message.send";

    private $isGroupRoom = false;
    private $toId;

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Plugin\DuckChatMessageSendRequest $request
     * @param \Zaly\Proto\Core\TransportData $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $message = $request->getMessage();

        $fromUserId = $message->getFromUserId();

        $msgRoomType = $message->getRoomType();
        $msgId = $message->getMsgId();
        $msgType = $message->getType();

        $result = false;

        if (Zaly\Proto\Core\MessageRoomType::MessageRoomGroup == $msgRoomType) {
            $this->isGroupRoom = true;
            $this->toId = $message->getToGroupId();

            //if group exist isLawful
            $isLawful = $this->checkGroupExisted($this->toId);
            if (!$isLawful) {
                //if group is not exist
                $noticeText = "group chat is not exist";
                $this->returnGroupNotLawfulMessage($msgId, $msgRoomType, $fromUserId, $this->toId, $noticeText);
                return;
            }

            $result = $this->ctx->Message_Client->sendGroupMessage($msgId, $fromUserId, $this->toId, $msgType, $message);

        } else if (Zaly\Proto\Core\MessageRoomType::MessageRoomU2 == $msgRoomType) {
            $this->isGroupRoom = false;
            $this->toId = $message->getToUserId();

            $fromMsgId = $this->buildU2MsgId($fromUserId);
            $result = $this->ctx->Message_Client->sendU2Message($fromMsgId, $this->toId, $fromUserId, $this->toId, $msgType, $message);

            $toMsgId = $this->buildU2MsgId($this->toId);
            $result = $this->ctx->Message_Client->sendU2Message($toMsgId, $fromUserId, $this->toId, $fromUserId, $msgType, $message);

            $this->ctx->Message_News->tellClientNews($this->isGroupRoom, $fromUserId);
        }

        $this->returnMessage($msgId, $msgRoomType, $msgType, $message, $fromUserId, $this->toId, $result);

        $this->ctx->Wpf_Logger->error("duckchat.message.send", "");

        return;
    }

    private function returnMessage($msgId, $msgRoomType, $msgType, $message, $fromUserId, $toUserId, $result)
    {
        $this->finish_request();

        //send friend news
        $this->ctx->Message_News->tellClientNews($this->isGroupRoom, $this->toId);

        //send push to friend
        $pushText = $this->getPushText($msgType, $message);

        $this->ctx->Push_Client->sendNotification($msgRoomType, $msgType, $fromUserId, $this->toId, $pushText);
    }

    //return if group is not lawful
    private function returnGroupNotLawfulMessage($msgId, $msgRoomType, $fromUserId, $groupId, $noticeText)
    {
        //finish request
        $this->finish_request();

        //proxy group message to u2
        $this->ctx->Message_Client->proxyGroupAsU2NoticeMessage($fromUserId, $fromUserId, $groupId, $noticeText);
        //send im.stc.news to client
        $this->ctx->Message_News->tellClientNews(false, $fromUserId);
    }

    //check group-message if lawful
    private function checkGroupExisted($groupId)
    {
        $groupProfile = $this->ctx->SiteGroupTable->getGroupInfo($groupId);
        if ($groupProfile) {
            return true;
        }
        return false;
    }

    /**
     * @param $msgType
     * @param \Zaly\Proto\Core\Message $message
     * @return string
     */
    private function getPushText($msgType, $message)
    {
        switch ($msgType) {
            case \Zaly\Proto\Core\MessageType::MessageNotice:
                $notice = $message->getNotice();
                return $notice->getBody();
            case \Zaly\Proto\Core\MessageType::MessageText:
                $text = $message->getText();
                return $text->getBody();
        }
        return '';
    }

}