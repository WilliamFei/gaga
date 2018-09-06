<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/07/2018
 * Time: 8:51 PM
 */


class Http_File_DownloadMessageFileController extends \HttpBaseController
{
    public function index()
    {
        $tag = __CLASS__."-".__FUNCTION__;
        try{
            $fileId    = $_GET['fileId'];

            $isGroupMessage = isset($_GET['isGroupMessage']) ? $_GET['isGroupMessage'] : "";
            $messageId = isset($_GET['messageId']) ? $_GET['messageId'] : "";
            $returnBase64 = $_GET['returnBase64'];

            if($messageId) {
                if($isGroupMessage == true) {
                    $info = $this->ctx->SiteGroupMessageTable->checkUserCanLoadImg($messageId, $this->userId);
                    if(!$info) {
                        throw new Exception("can't load img");
                    }
                    $this->ctx->Wpf_Logger->info($tag, "info ==" . json_encode($info) );
                } else {

                    ////TODO u2 can load img
                    $info = $this->ctx->SiteU2MessageTable->queryMessageByMsgId([$messageId]);

                    if(!$info) {
                        throw new Exception("can't load img");
                    }
                    $info = array_shift($info);

                    if($info['fromUserId'] != $this->userId && $info['toUserId'] != $this->userId) {
                        throw new Exception("can't load img");
                    }
                }
                $contentJson = $info['content'];
                $contentArr  = json_decode($contentJson, true);
                $url = $contentArr['url'];
                if($url != $fileId) {
                    throw new Exception("get img content is not ok");
                }
            }

            $imgContent = $this->ctx->File_Manager->readFile($fileId);

            if(strlen($imgContent)<1) {
                throw new Exception("load img void");
            }
            header('Cache-Control: max-age=86400, public');
            header("Content-type:image/png");

            if($returnBase64) {
                echo base64_decode($imgContent);
            } else {
                echo $imgContent;
            }

        }catch (Exception $e) {
            header("Content-type:image/jpg");
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==" .$e->getMessage() );
            echo "failed";
        }
    }
}
