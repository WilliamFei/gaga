<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 6:15 PM
 */
class Duckchat_User_RelationController extends Duckchat_MiniProgramController
{
    private $classNameForRequest = '\Zaly\Proto\Plugin\DuckChatUserRelationRequest';
    private $classNameForResponse = '\Zaly\Proto\Plugin\DuckChatUserRelationResponse';

    public function rpcRequestClassName()
    {
        return $this->classNameForRequest;
    }

    /**
     * @param \Zaly\Proto\Plugin\DuckChatUserRelationRequest $request
     * @param \Google\Protobuf\Internal\Message $transportData
     */
    public function rpc(\Google\Protobuf\Internal\Message $request, \Google\Protobuf\Internal\Message $transportData)
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try{
            $userId = $request->getUserId();
            $oppositeUserId = $request->getOppositeUserId();
            $relation = $this->getUserRelation($userId, $oppositeUserId);
            $response = $this->getRelationResponse($relation);
            $this->setRpcError($this->defaultErrorCode, "");
            $this->rpcReturn($transportData->getAction(), $response);
        }catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg ==".$ex->getMessage());
            $errorCode = $this->zalyError->errorExistUser;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->setRpcError($errorCode, $errorInfo);
            $this->rpcReturn($transportData->getAction(), new $this->classNameForResponse());
        }
    }

    private function getUserRelation($userId, $oppositeUserId)
    {
        $relationInfo = $this->ctx->SiteUserFriendTable->getRealtion($userId, $oppositeUserId);
        if($relationInfo ==  false) {
            return \Zaly\Proto\Core\FriendRelationType::FriendRelationInvalid;
        }
        return $relationInfo['relation'];
    }

    private function getRelationResponse($relation)
    {
        $response = new \Zaly\Proto\Plugin\DuckChatUserRelationResponse();
        $response->setRelationType($relation);
        return $response;
    }
}