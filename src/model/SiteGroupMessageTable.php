<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 23/07/2018
 * Time: 11:32 AM
 */


class SiteGroupMessageTable extends BaseTable
{
    private $table = "siteGroupMessage";
    private $groupTable = "siteGroup";
    private $columns = ["id", "msgId", "groupId", "fromUserId", "msgType", "content", "msgTime"];
    private $pointerTable = "siteGroupMessagePointer";
    private $pointerColumns = ["groupId", "userId", "deviceId", "clientSideType", "pointer"];


    function init()
    {
    }

    /**
     * 插入新消息
     * @param $groupMessage
     * @return bool
     * @throws Exception
     */
    function insertMessage($groupMessage)
    {
        return $this->insertData($this->table, $groupMessage, $this->columns);
    }

    /**
     * 查询群组消息
     * @param $groupId
     * @param $offset
     * @param $limitCount
     * @return array
     * @throws Exception
     */
    public function queryMessage($groupId, $offset, $limitCount)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $queryFieldsArr = ["b.id", "b.msgId", "b.groupId", "b.fromUserId", "b.msgType", "b.content", "b.msgTime"];
        $queryFields = implode(",", $queryFieldsArr);
        $sql = "select $queryFields from $this->groupTable as a left join $this->table as b on a.groupId=b.groupId where b.id>:offset and b.groupId=:groupId order by b.id limit :limitCount;";

        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":groupId", $groupId);
            $prepare->bindValue(":offset", $offset);
            $prepare->bindValue(":limitCount", $limitCount);
            $prepare->execute();
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } finally {
            $costTime = microtime(true) - $startTime;
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [$groupId, $offset, $limitCount], $costTime);
        }

        return [];
    }

    /**
     * 通过msgid查询表中消息
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

        $queryFieldsArr = ["b.id", "b.msgId", "b.groupId", "b.fromUserId", "b.msgType", "b.content", "b.msgTime"];
        $queryFields = implode(",", $queryFieldsArr);
        $sql = "select $queryFields from $this->table ";

        try {
            $sql .= "where msgId in (";
            for ($i = 0; $i < count($msgIdArrays); $i++) {
                if ($i == 0) {
                    $sql .= $msgIdArrays[$i];
                } else {
                    $sql .= "," + $msgIdArrays[$i];
                }
            }
            $sql .= ");";

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->execute();

            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, "", $startTime);
        }

        return [];
    }


    public function updatePointer($groupId, $userId, $deviceId, $pointer)
    {
        $result = $this->updateGroupPointer($groupId, $userId, $deviceId, $pointer);

        if (!$result) {
            $this->saveGroupPointer($groupId, $userId, $deviceId, $pointer);
        }

        return false;
    }

    private function updateGroupPointer($groupId, $userId, $deviceId, $pointer)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;

        $sql = "update $this->pointerTable set pointer=:pointer where groupId=:groupId and userId=:userId and deviceId=:deviceId";

        try {
            $prepare = $this->db->prepare($sql);
//            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":pointer", $pointer, PDO::PARAM_INT);
            $prepare->bindValue(":groupId", $groupId);
            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":deviceId", $deviceId);

            $result = $prepare->execute();

            if ($result) {
                $count = $prepare->rowCount();
                return $count > 0;
            }
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [$pointer, $groupId, $userId, $deviceId], $startTime);
        }

        return false;
    }


    /**
     * @param $groupId
     * @param $userId
     * @param $deviceId
     * @param $pointer
     * @return bool
     * @throws Exception
     */
    private function saveGroupPointer($groupId, $userId, $deviceId, $pointer)
    {
        $data = [
            "groupId" => $groupId,
            "userId" => $userId,
            "deviceId" => $deviceId,
            "pointer" => $pointer
        ];
        return $this->insertData($this->pointerTable, $data, $this->pointerColumns);
    }

    /**
     * 查询用户的群组消息游标
     *
     * @param $groupId
     * @param $userId
     * @param $deviceId
     * @return int
     */
    public function queryPointer($groupId, $userId, $deviceId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select pointer from $this->pointerTable where groupId=:groupId and userId=:userId and deviceId=:deviceId";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":groupId", $groupId);
            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":deviceId", $deviceId);

            $prepare->execute();

            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $result["pointer"];
            }

        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["groupId" => $groupId, "userId" => $userId, "deviceId" => $deviceId], $startTime);
        }

        return 0;
    }

    /**
     * 查询群组某个用户的所有游标中的max value
     * @param string $groupId
     * @param string $userId
     * @return int
     */
    public function queryMaxPointerByUser($groupId, $userId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select max(pointer) as pointer from $this->pointerTable where groupId=:groupId and userId=:userId";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":groupId", $groupId);
            $prepare->bindValue(":userId", $userId);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_ASSOC)["pointer"];
            if (!empty($result)) {
                return $result;
            }
            return 0;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["groupId" => $groupId, "userId" => $userId], $startTime);
        }
    }

    /**
     * 查询群组消息的ID（游标中）的max value
     * @param string $groupId
     * @return int
     */
    public function queryMaxIdByGroup($groupId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select max(id) as pointer from $this->table where groupId=:groupId";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":groupId", $groupId);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_ASSOC)["pointer"];
            if (!empty($result)) {
                return $result;
            }
            return 0;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $groupId, $startTime);
        }
    }


    public function getLastActiveFromGroupIds($groupIds)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $groupIdStr = implode("','", $groupIds);
        $sql = "select 
                    name, b.groupId,  b.content, b.msgTime, b.msgType 
                from 
                    siteGroup 
                inner join 
                    (select  
                        siteGroupMessage.groupId, siteGroupMessage.content, siteGroupMessage.msgTime, msgType 
                    from 
                        siteGroupMessage 
                    where 
                        groupId in ('$groupIdStr') 
                    group by 
                        groupId 
                    order by msgTime Desc) 
                as 
                    b 
                on 
                    b.groupId = siteGroup.groupId;";
        $prepare = $this->db->prepare($sql);
        $this->handlePrepareError($tag, $prepare);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $groupIds, $startTime);
        return $result;
    }

    public function checkUserCanLoadImg($msgId, $userId)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "." . __FUNCTION__;
        $sql = "select 
                    SiteGroupUser.userId,
                    siteGroupMessage.groupId,
                    siteGroupMessage.content
                from 
                    siteGroupMessage 
                inner join 
                    SiteGroupUser 
                on
                    siteGroupMessage.groupId = SiteGroupUser.groupId
                where 
                    siteGroupMessage.msgId = :msgId
                and 
                    SiteGroupUser.userId = :userId;
                ";

        $prepare = $this->db->prepare($sql);
        $this->handlePrepareError($tag, $prepare);
        $prepare->bindValue(":msgId", $msgId);
        $prepare->bindValue(":userId", $userId);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ['userId' => $userId, 'msgId' => $msgId], $startTime);
        return $result;
    }
}