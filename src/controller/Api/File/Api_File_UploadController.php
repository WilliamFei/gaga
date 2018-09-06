<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 18/07/2018
 * Time: 8:32 AM
 */
class Api_File_UploadController extends \BaseController
{
    private $classNameForRequest  = '\Zaly\Proto\Site\ApiFileUploadRequest';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Site\ApiFileUploadRequest $request
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $file = $request->getFile();
        $fileType = $request->getFileType();
        $isMessageAttachment = $request->getIsMessageAttachment();

        $fileId = $this->ctx->File_Manager->saveFile($file);
        if (empty($fileId)) {
            $this->setRpcError("error.file.wrong", "the file type is not supported.");
        }

        $response = new \Zaly\Proto\Site\ApiFileUploadResponse();
        $response->setFileId($fileId);
        $this->setRpcError($this->defaultErrorCode, "");
        $this->rpcReturn($this->getRequestAction(), $response);
    }
}

