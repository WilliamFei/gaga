<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 20/07/2018
 * Time: 3:41 PM
 */

class Api_Group_DeleteController extends Api_Group_BaseController
{
    private $classNameForRequest   = '\Zaly\Proto\Site\ApiGroupDeleteRequest';
    private $classNameForResponse  = '\Zaly\Proto\Site\ApiGroupDeleteResponse';
    public $userId;

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        ///处理request，
        $tag = __CLASS__ .'-'.__FUNCTION__;
        try{
            $groupId = $request->getGroupId();
            if(!$groupId) {
                $errorCode = $this->zalyError->errorGroupDelete;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                $this->setRpcError($errorCode, $errorInfo);
                throw new Exception($errorInfo);
            }
            $this->isGroupOwner($groupId);
            $this->deleteGroupInfo($groupId);
            // TODO 用户怎么处理
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=".$ex->getMessage());
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }
}