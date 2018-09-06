<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 19/07/2018
 * Time: 2:57 PM
 */

class SiteUserTable extends BaseTable
{
    private $table = "siteUser";
    private $columns = [
        "id",
        "userId",
        "loginName",
        "loginNameLowercase",
        "nickname",
        "nicknameInLatin",
        "avatar",
        "availableType",
        "countryCode",
        "phoneId",
        "friendVersion",
        "timeReg"
    ];

    private $selectColumns;

    private $friendTable = "siteUserFriend";

    public function init()
    {
        $this->selectColumns = implode(",", $this->columns);
    }

    public function insertUserInfo($userInfo)
    {
        return $this->insertData($this->table, $userInfo, $this->columns);
    }

    public function getUserByUserId($userId)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $sql = "select $this->selectColumns from $this->table where userId=:userId";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":userId", $userId);
            $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $userId, $startTime);
            return $user;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            return false;
        }
    }

    public function getUserByLoginName($loginName)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $sql = "select $this->selectColumns from $this->table where loginName=:loginName";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":loginName", $loginName);
            $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $loginName, $startTime);
            return $user;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex);
            return false;
        }
    }

    public function getUserByLoginNameLowercase($loginNameLowercase)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $sql = "select $this->selectColumns from $this->table where loginNameLowercase=:loginNameLowercase;";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":loginNameLowercase", $loginNameLowercase);
            $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $loginNameLowercase, $startTime);
            return $user;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex);
            return false;
        }
    }

    public function getUserByPhoneId($phoneId)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $sql = "select $this->selectColumns from $this->table where phoneId=:phoneId;";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":phoneId", $phoneId);
            $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $phoneId, $startTime);
            return $user;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex);
            return false;
        }
    }

    public function getUserNickName($userId)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $sql = "select nickname from $this->table where userId=:userId";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":userId", $userId);
            $flag = $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $userId, $startTime);

            if ($flag && $user) {
                return $user['nickname'];
            }
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            return false;
        }
        return '';
    }

    public function getFriendProfile($userId, $friendId)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {

            $sql = "SELECT
                    a.userId,a.loginName,a.nickname,a.nicknameInLatin,a.avatar,a.availableType,b.aliasName,b.aliasNameInLatin,b.relation,b.mute
                FROM
                    $this->table AS a LEFT JOIN (SELECT userId,friendId,aliasName,aliasNameInLatin,relation,mute FROM $this->friendTable WHERE userId=:userId)AS b ON b.friendId = a.userId
                WHERE 
                  a.userId=:friendId;";

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":userId", $userId);
            $prepare->bindValue(":friendId", $friendId);

            $prepare->execute();
            $user = $prepare->fetch(\PDO::FETCH_ASSOC);
            return $user;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["userId" => $userId, "friendId" => $friendId], $startTime);
        }

    }

    public function getSiteUserListByOffset($offset, $length)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "-" . __FUNCTION__;
        $sql = "select  
                        $this->selectColumns 
                    from 
                        siteUser 
                    order by id DESC limit :offset, :length";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":offset", $offset);
            $prepare->bindValue(":length", $length);
            $prepare->execute();
            $result = $prepare->fetchAll(\PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex);
            return false;
        } finally {
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [$offset, $length], $startTime);
        }
    }

    public function getUserListNotInGroup($groupId, $offset, $pageSize)
    {
        try {
            $startTime = microtime(true);
            $tag = __CLASS__ . "-" . __FUNCTION__;
            ////TODO 待优化
            $sql = "select  
                        $this->selectColumns 
                    from 
                        siteUser 
                    where 
                        userId 
                    not in 
                        (select 
                            userId 
                        from 
                            siteGroupUser 
                        where groupId=:groupId) 
                    order by 
                        timeReg DESC 
                    limit 
                        :offset, :pageSize";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":groupId", $groupId);
            $prepare->bindValue(":offset", $offset);
            $prepare->bindValue(":pageSize", $pageSize);
            $prepare->execute();
            $result = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $groupId, $startTime);
            return $result;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            return false;
        }
    }

    public function getUserCount($groupId)
    {
        try {
            $startTime = microtime(true);
            $tag = __CLASS__ . "-" . __FUNCTION__;
            ////TODO 待优化
            $sql = "select count(userId) as `count` from siteUser where userId not in (select userId from siteGroupUser where groupId=:groupId);";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);

            $prepare->bindValue(":groupId", $groupId);
            $prepare->execute();
            $result = $prepare->fetchColumn();
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $groupId, $startTime);
            return $result;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            return false;
        }
    }

    public function getUserByUserIds($userIds)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        try {
            $userIdStr = implode("','", $userIds);
            $sql = "select $this->selectColumns from $this->table where userId in ('$userIdStr')";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->execute();
            $results = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $userIdStr, $startTime);
            return $results;

        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, "error_msg=" . $ex->getMessage());
            return false;
        }
    }

    public function getUserFriendVersion($userId)
    {
        $tag = __CLASS__ . "-" . __FILE__;
        $startTime = microtime(true);
        $sql = "select friendVersion from $this->table where userId=:userId;";
        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":userId", $userId);
            $prepare->execute();

            $results = $prepare->fetch(\PDO::FETCH_ASSOC);

            if (!empty($results) && !empty($results['friendVersion'])) {
                return $results['friendVersion'];
            }

            return 0;
        } finally {
            $this->ctx->wpf_Logger->writeSqlLog($tag, $sql, $results, $startTime);
        }
    }

    public function updateUserData($where, $data)
    {
        return $this->updateInfo($this->table, $where, $data, $this->columns);
    }

    public function updateUserFriendVersion($userId, $friendVersion)
    {
        $where = ['userId' => $userId];
        $data = ['friendVersion' => $friendVersion];
        return $this->updateInfo($this->table, $where, $data, $this->columns);

    }

}