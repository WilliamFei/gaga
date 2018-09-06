<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_Group_ProfileController extends ManageController
{

    public function doRequest()
    {
        $groupId = $_GET['groupId'];

        $params = $this->getGroupProfile($groupId);
        $params['lang'] = $this->language;

        $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_DEFAULT_GROUPS);

        $defaultGroupsStr = $config[SiteConfig::SITE_DEFAULT_GROUPS];

        if ($defaultGroupsStr) {
            $defaultGroupsList = explode(",", $defaultGroupsStr);

            if (in_array($groupId, $defaultGroupsList)) {
                $params['isDefaultGroup'] = 1;
            }
        }

        echo $this->display("manage_group_profile", $params);
        return;
    }

    private function getGroupProfile($groupId)
    {
        return $this->ctx->SiteGroupTable->getGroupInfo($groupId);
    }

}