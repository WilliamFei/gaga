<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 10/08/2018
 * Time: 4:06 PM
 */

class Message_News
{

    private $ctx;
    private $stc_news = "im.stc.news";

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
    }

    /**
     * tell client im.stc.news
     *
     * @param $isGroup
     * @param $toId
     * @throws Exception
     */
    public function tellClientNews($isGroup, $toId)
    {
        error_log("tell client news isGroup=" . $isGroup . " toId=" . $toId);

        if ($isGroup == false) {
            //u2 Message
            $this->ctx->Gateway_Client->sendMessageByUserId($toId, $this->stc_news, new Zaly\Proto\Client\ImStcNewsRequest());
        } else {
            //group Message
            $groupUserIdList = $this->ctx->SiteGroupUserTable->getGroupAllMembersId($toId);
            $this->ctx->Wpf_Logger->info($this->stc_news, "get group memberlist=" . json_encode($groupUserIdList));
            if (!empty($groupUserIdList)) {
                foreach ($groupUserIdList as $memberIdMap) {
                    $userId = $memberIdMap["userId"];
                    $this->ctx->Wpf_Logger->info($this->stc_news, "get group memberId=" . $userId);
                    $this->ctx->Gateway_Client->sendMessageByUserId($userId, $this->stc_news, new Zaly\Proto\Client\ImStcNewsRequest());
                }
            }

        }

    }
}