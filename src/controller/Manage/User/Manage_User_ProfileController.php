<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_User_ProfileController extends ManageController
{

    public function doRequest()
    {
        $userId = $_GET['userId'];

        $params = $this->getUserProfile($userId);
        $params['lang'] = $this->language;

        $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_MANAGERS);
        $siteManagerStr = $config[SiteConfig::SITE_MANAGERS];

        if ($siteManagerStr) {
            $isSiteManager = in_array($userId, explode(",", $siteManagerStr));
            $params['isSiteManager'] = $isSiteManager;
        }


        $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_DEFAULT_FRIENDS);
        $defaultFriendStr = $config[SiteConfig::SITE_DEFAULT_FRIENDS];
        if ($defaultFriendStr) {
            $isDefaultFriend = in_array($userId, explode(",", $defaultFriendStr));
            $params['isDefaultFriend'] = $isDefaultFriend;
        }

        echo $this->display("manage_user_profile", $params);
        return;
    }

    private function getUserProfile($userId)
    {
        return $this->ctx->SiteUserTable->getUserByUserId($userId);
    }

}