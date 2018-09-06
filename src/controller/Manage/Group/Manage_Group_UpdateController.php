<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_Group_UpdateController extends ManageController
{

    public function doRequest()
    {
        $groupId = $_POST['groupId'];
        $updateKey = $_POST['key'];
        $updateValue = $_POST['value'];

        $this->ctx->Wpf_Logger->info("-------------", "groupId=" . $groupId);
        $this->ctx->Wpf_Logger->info("-------------", "key=" . $updateKey);
        $this->ctx->Wpf_Logger->info("-------------", "value=" . $updateValue);

        $response = [
            'errCode' => "error"
        ];

        try {

            switch ($updateKey) {
                case "groupId":
                    throw new Exception("update groupId error");
                case "name":
                case "groupName":
                    if (empty($updateValue)) {
                        throw new Exception("group-name is empty");
                    }

                    $groupName = $updateValue;
                    $pinyin = new \Overtrue\Pinyin\Pinyin();
                    $groupNameInLatin = $pinyin->permalink($groupName, "");;

                    if ($this->updateGroupName($groupId, $groupName, $groupNameInLatin)) {
                        $response['errCode'] = "success";
                    }
                    break;
                case "maxMembers":
                    if (empty($updateValue)) {
                        throw new Exception("maxMembers is null");
                    }

                    if ($this->updateGroupProfile($groupId, $updateKey, $updateValue)) {
                        $response['errCode'] = "success";
                    }
                    break;
                case "avatar":
                    // TODO
                    break;
                case "enableShareGroup":
                    // TODO
//                    if ($this->updateGroupProfile($groupId, $updateKey, $updateValue)) {
//                        $response['errCode'] = "success";
//                    }

                    break;
                case "addDefaultGroup":
                    // update config
                    $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_DEFAULT_GROUPS);
                    $defaultGroupStr = $config[SiteConfig::SITE_DEFAULT_GROUPS];

                    $this->ctx->Wpf_Logger->info("manage-add-default-group----", $defaultGroupStr);

                    if ($updateValue == 1) {
                        //add
                        if (empty($defaultGroupStr)) {
                            $defaultGroupStr = $groupId;
                        } else {
                            $defaultGroupList = explode(",", $defaultGroupStr);

                            if (!in_array($groupId, $defaultGroupList)) {
                                $defaultGroupList[] = $groupId;
                            }

                            $defaultGroupStr = implode(",", $defaultGroupList);
                        }

                    } else {
                        //remove
                        if (!empty($defaultGroupStr)) {

                            $defaultGroupList2 = explode(",", $defaultGroupStr);

                            $this->ctx->Wpf_Logger->info("manage-add-default-list---- ", "result=" . in_array($groupId, $defaultGroupList2));

                            if (in_array($groupId, $defaultGroupList2)) {
                                $defaultGroupList2 = array_diff($defaultGroupList2, [$groupId]);
                            }

                            $defaultGroupStr = implode(",", $defaultGroupList2);
                        }

                    }

                    $this->ctx->Wpf_Logger->info("manage-add-default-group----new ", $defaultGroupStr);
                    //update site default group
                    if ($this->updateSiteDefaultGroups($defaultGroupStr)) {
                        $response['errCode'] = "success";
                    }
                    break;
                default:
                    break;
            }

        } catch (Exception $e) {
            $response['errInfo'] = $e->getMessage();
            $this->ctx->Wpf_Logger->error("manage.user.update", $e);
        }

        echo json_encode($response);
        return;
    }

    private function updateGroupName($groupId, $newName, $newNameInLatin)
    {
        $where = [
            'groupId' => $groupId,
        ];

        $data = [
            'name' => $newName,
            'nameInLatin' => $newNameInLatin,
        ];

        return $this->ctx->SiteGroupTable->updateGroupInfo($where, $data);
    }

    private function updateGroupProfile($groupId, $updateKey, $updateValue)
    {
        $where = [
            'groupId' => $groupId,
        ];

        $data = [
            $updateKey => $updateValue,
        ];

        return $this->ctx->SiteGroupTable->updateGroupInfo($where, $data);
    }

    private function updateSiteDefaultGroups($newDefaultGroups)
    {
        return $this->ctx->SiteConfigTable->updateSiteConfig(SiteConfig::SITE_DEFAULT_GROUPS, $newDefaultGroups);
    }
}