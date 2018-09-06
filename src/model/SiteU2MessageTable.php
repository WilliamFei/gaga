<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 23/07/2018
 * Time: 11:32 AM
 */


class siteU2MessageTable extends BaseTable
{
    private $table = "siteU2Message";
    private $columns = ["id", "msgId", "userId", "fromUserId", "toUserId", "roomType", "msgType", "content", "msgTime"];

    private $pointerTable = "siteU2MessagePointer";
    private $pointerColumns = ["userId", "deviceId", "clientSideType", "pointer"];


    function init()
    {
    }

    /**
     * @param $u2Message
     * @return bool
     * @throws Exception
     */
    function insertMessage($u2Message)
    {
        return $this->insertData($this->table, $u2Message, $this->columns);
    }

    /**
     * 查询群组消息
     * @param string $userId
     * @param int $offset
     * @param int $limitCount
     * @return array
     * @throws Exception
     */
    public function queryMessage($userId, $offset, $limitCount)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;

        $queryFields = implode(",", $this->columns);
        $sql = "select $queryFields from $this->table where id>:offset and userId=:userId order by id limit :limitCount;";

        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":offset", $offset);
            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":limitCount", $limitCount);

            $prepare->execute();
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } finally {
            $costTime = microtime(true) - $startTime;
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [$userId, $offset, $limitCount], $costTime);
        }

        return [];
    }

    /**
     * 通过msgId查询表中消息
     *
     * @param $msgIdArrays
     * @return array
     * @throws Exception
     */
    public function queryMessageByMsgId($msgIdArrays)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;

        $result = empty($msgIdArrays);

        if ($result) {
            return [];
        }

        $queryFields = implode(",", $this->columns);
        $sql = "select $queryFields from $this->table ";

        try {
            $sql .= "where msgId in ('";
            for ($i = 0; $i < count($msgIdArrays); $i++) {
                if ($i == 0) {
                    $sql .= $msgIdArrays[$i];
                } else {
                    $sql .= "','" + $msgIdArrays[$i];
                }
            }
            $sql .= "') limit 100;";

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->execute();

            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $msgIdArrays, $startTime);
        }

        return [];
    }


    /**
     * @param $userId
     * @param $deviceId
     * @param $clientSideType
     * @param $pointer
     * @return bool
     * @throws Exception
     */
    public function updatePointer($userId, $deviceId, $clientSideType, $pointer)
    {
        $result = $this->updateU2Pointer($userId, $deviceId, $clientSideType, $pointer);

        if (!$result) {
            $this->saveU2Pointer($userId, $deviceId, $clientSideType, $pointer);
        }

        return false;
    }

    /**
     * @param $userId
     * @param $deviceId
     * @param $clientSideType
     * @param $pointer
     * @return bool
     * @throws Exception
     */
    private function updateU2Pointer($userId, $deviceId, $clientSideType, $pointer)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;

        $sql = "update $this->pointerTable set pointer=:pointer,clientSideType=:clientSideType where userId=:userId and deviceId=:deviceId";


        try {

            if (empty($clientSideType)) {
                $clientSideType = Zaly\Proto\Core\UserClientType::UserClientMobileInvalid;
            }

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":pointer", $pointer, PDO::PARAM_INT);
            $prepare->bindValue(":clientSideType", $clientSideType);
            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":deviceId", $deviceId);

            $result = $prepare->execute();

            if ($result) {
                $count = $prepare->rowCount();
                return $count > 0;
            }
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [$pointer, $userId, $deviceId], $startTime);
        }

        return false;
    }


    /**
     * 保存二人消息游标
     *
     * @param $userId
     * @param $deviceId
     * @param $clientSideType
     * @param $pointer
     * @return bool
     * @throws Exception
     */
    private function saveU2Pointer($userId, $deviceId, $clientSideType, $pointer)
    {
        if (empty($clientSideType)) {
            // 0：默认未知的类型
            // 1：mobile
            // 2：web
            $clientSideType = Zaly\Proto\Core\UserClientType::UserClientMobileInvalid;
        }

        $data = [
            "userId" => $userId,
            "deviceId" => $deviceId,
            "clientSideType" => $clientSideType,
            "pointer" => $pointer
        ];
        return $this->insertData($this->pointerTable, $data, $this->pointerColumns);
    }

    /**
     * 查询用户的群组消息游标
     *
     * @param $userId
     * @param $deviceId
     * @return int
     * @throws Exception
     */
    public function queryU2Pointer($userId, $deviceId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select pointer from $this->pointerTable where userId=:userId and deviceId=:deviceId";

        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":deviceId", $deviceId);

            $prepare->execute();

            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $result["pointer"];
            }

            return 0;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["userId" => $userId, "deviceId" => $deviceId], $startTime);
        }

    }

    /**
     * 多个设备中，最大的那个游标
     *
     * @param $userId
     * @return int
     * @throws Exception
     */
    public function queryMaxU2Pointer($userId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select max(pointer) as pointer from $this->pointerTable where userId=:userId";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":userId", $userId);
            $prepare->execute();
            $pointerInfo = $prepare->fetch(PDO::FETCH_ASSOC);

            if (!empty($pointerInfo)) {
                return $pointerInfo["pointer"];
            }
            return 0;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["userId" => $userId], $startTime);
        }
    }

    public function queryMaxMsgId($userId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select max(id) as pointer from $this->table where userId=:userId";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":userId", $userId);
            $prepare->execute();
            $pointerInfo = $prepare->fetch(PDO::FETCH_ASSOC);

            if (!empty($pointerInfo)) {
                return $pointerInfo['pointer'];
            }
            return 0;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["userId" => $userId], $startTime);
        }
    }

    public function getU2LastChat($userId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;

        $sql = "select 
            userId, fromUserId, toUserId , msgTime, content, msgType
        from 
            (
                select siteU2Message.msgId, siteU2Message.msgType , siteU2Message.userId, siteU2Message.fromUserId, siteU2Message.toUserId, siteU2Message.content , (siteU2Message.toUserId || siteU2Message.fromUserId) as concatId, siteU2Message.msgTime from siteU2Message where (siteU2Message.fromUserId in (select friendId  from siteUserFriend where userId = :userId) and siteU2Message.toUserId = :userId)
                union 
                select siteU2Message.msgId, siteU2Message.msgType ,siteU2Message.userId, siteU2Message.fromUserId, siteU2Message.toUserId, siteU2Message.content,  (siteU2Message.fromUserId || siteU2Message.toUserId) as concatId , siteU2Message.msgTime from siteU2Message where (siteU2Message.toUserId in (select friendId  from siteUserFriend where userId = :userId) and siteU2Message.fromUserId = :userId)
                order by msgTime asc
         ) as Message  group by concatId order by msgTime Desc;";
        $prepare = $this->db->prepare($sql);
        $this->handlePrepareError($tag, $prepare);
        $prepare->bindValue(":userId", $userId);
        $prepare->execute();
        $results = $prepare->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }


}