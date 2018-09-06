<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:59 AM
 */

class Manage_User_DeleteController extends ManageController
{

    public function doRequest()
    {
        $userId = $_POST['userId'];

        $this->ctx->Wpf_Logger->info("-------", "userId=" . $userId);

        $response = [
            'errCode' => "error",
        ];

        try {

            //判断userId是否为siteOwner
            $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_OWNER);

            $siteOwner = $config[SiteConfig::SITE_OWNER];

            if ($siteOwner == $userId) {
                throw new Exception("can't remove site owner");
            }

            $config = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_MANAGERS);

            //delete manager

            $config3 = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_DEFAULT_FRIENDS);

            //delete default friends


            if ($this->deleteUser($userId)) {
                $response['errCode'] = "success";
            }
        } catch (Exception $e) {
            $response['errInfo'] = $e->getMessage();
            $this->ctx->Wpf_Logger->error("manage.user.delete.error", $e);
        }

        echo json_encode($response);
        return;
    }

    private function deleteUser($userId)
    {
        //delete user session

        //delete user profile

        //delete user message

        //delete user message pointer
        return true;
    }

}