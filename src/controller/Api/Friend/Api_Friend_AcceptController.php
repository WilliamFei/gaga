<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 02/08/2018
 * Time: 10:02 AM
 */

class Api_Friend_AcceptController extends BaseController
{

    protected $action = "api.friend.accept";
    private $classNameForRequest = '\Zaly\Proto\Site\ApiFriendAcceptRequest';
    private $classNameForResponse = '\Zaly\Proto\Site\ApiFriendAcceptResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiFriendAcceptRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $userId = $this->userId;
        $applyUserId = $request->getApplyUserId();
        $isAgree = $request->getAgree();

        $result = false;

        $this->ctx->Wpf_Logger->info("---------------",
            "userId=" . $userId . " applyUserId=" . $applyUserId . " isAgree=" . $isAgree);

        if ($isAgree) {
            $result = $this->agreeFriendApply($userId, $applyUserId);

            if ($result) {
                $this->removeFriendApply($applyUserId, $userId);
                $this->removeFriendApply($userId, $applyUserId);
            }

        } else {
            $this->ctx->Wpf_Logger->info("---------------", "do remove friend apply");
            $result = $this->removeFriendApply($applyUserId, $userId);
        }


        if ($result) {
            $this->setRpcError("success", "");
        } else {
            $this->setRpcError("error.alert", "");
        }

        $this->setRpcError($this->defaultErrorCode, "");
        $this->rpcReturn($this->action, new $this->classNameForResponse());
    }

    protected function agreeFriendApply($userId, $applyUserId)
    {
        //查询 version

        $relation1 = $this->ctx->SiteUserFriendTable->isFollow($userId, $applyUserId);

        if ($relation1 != 1) {
            $success = $this->ctx->SiteUserFriendTable->saveUserFriend($userId, $applyUserId);

            if ($success) {
                //更新 version
            } else {
                return false;
            }
        }

        $relation2 = $this->ctx->SiteUserFriendTable->isFollow($applyUserId, $userId);

        if ($relation2 != 1) {
            //查询version
            $success = $this->ctx->SiteUserFriendTable->saveUserFriend($applyUserId, $userId);


            if ($success) {
                //更新version
            } else {
                return false;
            }

        }

        $applyData = $this->ctx->SiteFriendApplyTable->getApplyData($userId, $applyUserId);
        $greetings = $applyData['greetings'];

        $this->proxyNewFriendMessage($userId, $applyUserId, $greetings);
        return true;
    }

    /**
     * from apply to
     *
     * @param $fromUserId
     * @param $toUserId
     * @return bool
     */
    protected function removeFriendApply($fromUserId, $toUserId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            return $this->ctx->SiteFriendApplyTable->deleteApplyData($fromUserId, $toUserId);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, e);
        }
        return false;
    }

    private function proxyNewFriendMessage($agreeUserId, $applyUserId, $greetings)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $fromUserId = $agreeUserId;

            $text = "I accept your friend apply, let's talk";

//            if ($this->language == Zaly\Proto\Core\UserClientLangType::UserClientLangZH) {
//                $text = "我接受了你的好友申请，现在开始聊天吧";
//            }

            $this->ctx->Message_Client->proxyU2TextMessage($applyUserId, $fromUserId, $applyUserId, $text);

        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }

        try {
            if (empty($greetings)) {
                $greetings = "we are friends, just talk to me";

                if ($this->language == Zaly\Proto\Core\UserClientLangType::UserClientLangZH) {
                    $greetings = "我添加了你为好友，开始聊天吧";
                }
            }
            $this->ctx->Message_Client->proxyU2TextMessage($fromUserId, $applyUserId, $fromUserId, $greetings);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }

    }

}