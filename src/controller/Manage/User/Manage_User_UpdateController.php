<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_User_UpdateController extends ManageController
{

    public function doRequest()
    {
        $userId = $_POST['userId'];
        $updateKey = $_POST['key'];
        $updateValue = $_POST['value'];

        $response = [
            'errCode' => "error"
        ];

        try {

            switch ($updateKey) {
                case "userId":
                    throw new Exception("userId update permission error");
                case "nickname":
                    if (empty($updateValue)) {
                        throw new Exception("nickname is null");
                    }

                    $pinyin = new \Overtrue\Pinyin\Pinyin();
                    $nicknameInLatin = $pinyin->permalink($updateValue, "");

                    if ($this->updateUserNickname($userId, $updateValue, $nicknameInLatin)) {
                        $response['errCode'] = "success";
                    }
                    break;
                case "loginName":
                    if (empty($updateValue)) {
                        throw new Exception("loginName is null");
                    }

                    $loginNameLowercase = strtolower($updateValue);

                    if ($this->updateUserLoginName($userId, $updateValue, $loginNameLowercase)) {
                        $response['errCode'] = "success";
                    }
                    break;
                case "avatar":
                    if (empty($updateValue)) {
                        throw new Exception("user avatar is null");
                    }

                    if ($this->updateUserProfile($userId, $updateKey, $updateValue)) {
                        $response['errCode'] = "success";
                    }

                    break;
                case "availableType":
                    // #TODO
                    break;
                case "addDefaultFriend":
                    if ($this->updateSiteDefaultFriends($userId, $updateValue)) {
                        $response['errCode'] = "success";
                    }
                    break;
                case "addSiteManager":
                    if ($this->updateSiteManagers($userId, $updateValue)) {
                        $response['errCode'] = "success";
                    }
                    break;
                default:
                    throw new Exception("known update field:" . $updateKey);
            }
        } catch (Exception $e) {
            $response['errInfo'] = $e->getMessage();
            $this->ctx->Wpf_Logger->error("manage.user.update", $e);
        }

        echo json_encode($response);
        return;
    }

    private function updateUserNickname($userId, $nickname, $nicknameInLatin)
    {
        $where = [
            'userId' => $userId
        ];

        $data = [
            'nickname' => $nickname,
            'nicknameInLatin' => $nicknameInLatin,
        ];

        return $this->ctx->SiteUserTable->updateUserData($where, $data);
    }

    private function updateUserLoginName($userId, $loginName, $loginNameLowercase)
    {
        $where = [
            'userId' => $userId
        ];

        $data = [
            'loginName' => $loginName,
            'loginNameLowercase' => $loginNameLowercase,
        ];

        return $this->ctx->SiteUserTable->updateUserData($where, $data);
    }

    private function updateUserProfile($userId, $updateName, $updateValue)
    {
        $where = [
            'userId' => $userId
        ];

        $data = [
            $updateName => $updateValue
        ];

        return $this->ctx->SiteUserTable->updateUserData($where, $data);
    }

    private function updateSiteDefaultFriends($userId, $updateValue)
    {

        $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_DEFAULT_FRIENDS);

        $defaultFriendStr = $config[SiteConfig::SITE_DEFAULT_FRIENDS];
        if ($updateValue == 1) {
            //add
            if (empty($defaultFriendStr)) {
                $defaultFriendStr = $userId;
            } else {
                $defaultFriendList = explode(",", $defaultFriendStr);
                if (!in_array($userId, $defaultFriendList)) {
                    $defaultFriendList[] = $userId;
                }
                $defaultFriendStr = implode(",", $defaultFriendList);
            }

        } else {
            //delete
            if (!empty($defaultFriendStr)) {
                $defaultFriendList2 = explode(",", $defaultFriendStr);

                if (in_array($userId, $defaultFriendList2)) {
                    $defaultFriendList2 = array_diff($defaultFriendList2, [$userId]);
                }

                $defaultFriendStr = implode(",", $defaultFriendList2);

            }
        }

        return $this->ctx->SiteConfigTable->updateSiteConfig(SiteConfig::SITE_DEFAULT_FRIENDS, $defaultFriendStr);
    }

    private function updateSiteManagers($userId, $updateValue)
    {

        $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_MANAGERS);

        $siteManagerStr = $config[SiteConfig::SITE_MANAGERS];

        if ($updateValue == 1) {
            //add
            if (empty($siteManagerStr)) {
                $siteManagerStr = $userId;
            } else {
                $siteManagerList = explode(",", $siteManagerStr);
                if (!in_array($userId, $siteManagerList)) {
                    $siteManagerList[] = $userId;
                }
                $siteManagerStr = implode(",", $siteManagerList);
            }

        } else {
            //delete
            if (!empty($siteManagerStr)) {
                $siteManagerList2 = explode(",", $siteManagerStr);

                if (in_array($userId, $siteManagerList2)) {
                    $siteManagerList2 = array_diff($siteManagerList2, [$userId]);
                }

                $siteManagerStr = implode(",", $siteManagerList2);

            }
        }

        return $this->ctx->SiteConfigTable->updateSiteConfig(SiteConfig::SITE_MANAGERS, $siteManagerStr);
    }
}