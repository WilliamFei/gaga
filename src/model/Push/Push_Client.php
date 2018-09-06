<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 10/08/2018
 * Time: 4:02 PM
 */

class Push_Client
{
    private $ctx;
    private $pushAction = "api.push.notification";

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
    }


    /**
     * @param int $roomType
     * @param int $msgType
     * @param $fromUserId
     * @param string $toId toUserId/toGroupId
     * @param $pushText
     */
    public function sendNotification($roomType, $msgType, $fromUserId, $toId, $pushText)
    {
        $pushRequest = new \Zaly\Proto\Platform\ApiPushNotificationRequest();
        try {

            $siteConfig = $this->getSiteConfig();
            $pushHeader = new \Zaly\Proto\Platform\PushHeader();

            //sign time seconds
            $currentTimeSeconds = $this->ctx->ZalyHelper->getCurrentTimeSeconds();
            $sitePrivatekey = $siteConfig[SiteConfig::SITE_ID_PRIK_PEM];
            $timeSingBase64 = base64_encode($this->ctx->ZalyRsa->sign($currentTimeSeconds, $sitePrivatekey));

            $pushHeader->setTimestampSeconds($currentTimeSeconds);
            $pushHeader->setSignTimestamp($timeSingBase64);

            $pushHeader->setSitePubkPemId($siteConfig['siteId']);
            $pushHeader->setSiteName($siteConfig['name']);
            $pushHeader->setSiteAddress($siteConfig['address']);

            $pushRequest->setPushHeader($pushHeader);
            $pushBody = new \Zaly\Proto\Platform\PushBody();//body 1
            $pushBody->setRoomType($roomType);//body 2
            $pushBody->setMsgType($msgType);
            $pushBody->setFromUserId($fromUserId);
            $userNickName = $this->ctx->SiteUserTable->getUserNickName($fromUserId);
            $pushBody->setFromUserName($userNickName);
            $pushBody->setPushContent($pushText);
            if (\Zaly\Proto\Core\MessageRoomType::MessageRoomGroup == $roomType) {
                $pushBody->setRoomId($toId);
                $pushBody->setRoomName($this->getGroupName($toId));
            }
            $deviceIds = $this->getPushDeviceIdList($roomType, $fromUserId, $toId);
            $pushBody->setToDevicePubkPemIds($deviceIds);
            $pushRequest->setPushBody($pushBody);

            $this->ctx->Wpf_Logger->info("api.push.notification", "request=" . $pushRequest->serializeToJsonString());

        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error("api.push.notification.build.payload", $e);
        }

        try {
            $pushURL = "http://open.akaxin.com:5208/?action=" . $this->pushAction . "&body_format=pb";
            $this->ctx->ZalyCurl->requestWithActionByPb($this->pushAction, $pushRequest, $pushURL, 'post');
            $this->ctx->Wpf_Logger->info("api.push.notification.response", "roomType=" . $pushRequest->serializeToJsonString());
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error("api.push.notification.error", $e);
        }

    }

    private function getSiteConfig()
    {
        $config = $this->ctx->SiteConfigTable->selectSiteConfig();

        if (!empty($config)) {
            $siteId = $config[SiteConfig::SITE_ID];
            if (empty($siteId)) {
                if ($config[SiteConfig::SITE_ID_PUBK_PEM]) {
                    $siteId = sha1($config[SiteConfig::SITE_ID_PUBK_PEM]);
                    $config[SiteConfig::SITE_ID] = $siteId;
                }
            }
        }
        $this->ctx->Wpf_Logger->info("site-config", json_encode($config));
        return $config;
    }

    private function getGroupName($groupId)
    {
        $groupName = $this->ctx->SiteGroupTable->getGroupName($groupId);
        return $groupName;
    }

    /**
     * @param \Zaly\Proto\Platform\PushRoomType $roomType
     * @param $fromUserId
     * @param $toId
     * @return array
     */
    private function getPushDeviceIdList($roomType, $fromUserId, $toId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        $deviceIdList = [];

        if (\Zaly\Proto\Core\MessageRoomType::MessageRoomU2 == $roomType) {

            $this->ctx->Wpf_Logger->info("api.push.notification", "userId=" . $toId);
            // u2
            $pushDeviceId = $this->getUserDeviceId($toId);

            $this->ctx->Wpf_Logger->info("api.push.notification", "u2 deviceId=" . $pushDeviceId);

            if (isset($pushDeviceId)) {
                $deviceIdList[] = $pushDeviceId;
            }

        } else {

            try {//group
                $groupMembers = $this->ctx->SiteGroupUserTable->getGroupAllMembersId($toId);

                if (!empty($groupMembers)) {
                    foreach ($groupMembers as $groupMember) {

                        $toUserId = $groupMember['userId'];

                        if ($fromUserId == $toUserId) {
                            continue;
                        }

                        $pushDeviceId = $this->getUserDeviceId($toUserId);

                        if (!empty($pushDeviceId)) {
                            $deviceIdList[] = $pushDeviceId;
                        }
                    }
                }
            } catch (Exception $e) {
                $this->ctx->Wpf_Logger->error($tag, $e);
            }

        }

        return $deviceIdList;
    }

    /**
     * @param $userId
     * @return null|\Zaly\Proto\Platform\PushTo
     */
    private function getUserDeviceId($userId)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            return $this->ctx->SiteSessionTable->getUserLatestDeviceId($userId);
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return null;
    }

    private function curl($url, $body)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }

}