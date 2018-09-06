<?php

/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 27/07/2018
 * Time: 8:51 PM
 */

class Http_File_UploadWebController extends \HttpBaseController
{

    private $defaultImgSize = 5*1024*1024;///5M
    public function index()
    {
        try{
            $tag = __CLASS__.'-'.__FUNCTION__;
            $isMessageAttachment = isset( $_POST['isMessageAttachment']) ?  $_POST['isMessageAttachment'] : false;

            $fileType = isset( $_POST['fileType']) ?  $_POST['fileType'] : \Zaly\Proto\Core\FileType::FileInvalid;
            if($fileType == "FileInvalid") {
                throw new Exception( "上传失败");
            }
            $file = $_FILES['file'];
            if($file['error'] != UPLOAD_ERR_OK) {
                throw new Exception("上传失败");
            }

            $originFileName = "";
            switch ($fileType) {
                case \Zaly\Proto\Core\FileType::FileImage:
                case "FileImage":
                    $originFileName = $this->saveImgFile($file);
                    break;
            }
            echo $originFileName;
        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "shaoye error msg =" . $ex->getMessage());
            header("HTTP/1.0 404 Not Found");
            echo "failed";
        }
    }

    private function saveImgFile($file)
    {
        $fileSize = $file['size'];
        $tmpName  = $file['tmp_name'];

        $tmpFile = file_get_contents($tmpName);
        $fileName = $this->ctx->File_Manager->saveFile($tmpFile);

        return $fileName;
    }
}

