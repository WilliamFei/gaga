<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_Group_DeleteController extends ManageController
{

    public function doRequest()
    {
        $groupId = $_POST['groupId'];


        $this->ctx->Wpf_Logger->info("-----manage.group.delete--------", "group=" . $groupId);

        $response = [
            'errCode' => "error",
        ];

        try {

            if ($this->deleteGroup($groupId)) {
                $response['errCode'] = "success";
            }

        } catch (Exception $e) {
            $response['errInfo'] = $e->getMessage();
            $this->ctx->Wpf_Logger->error("manage.group.delete.error", $e);
        }

        echo json_encode($response);
        return;
    }

    private function deleteGroup($groupId)
    {
        return $this->ctx->SiteGroupTable->deleteGroup($groupId);
    }

}