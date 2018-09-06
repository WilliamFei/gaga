<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 17/07/2018
 * Time: 11:24 AM
 */

class SitePluginTable extends BaseTable
{
    private $tableName = "sitePlugin";
    private $columns = [
        "id",
        "pluginId",
        "name",
        "logo",
        "sort",
        "landingPageUrl",
        "landingPageWithProxy",
        "usageType",
        "loadingType",
        "permissionType",
        "authKey",
        "addTime"
    ];

    private $queryColumns;

    public function init()
    {
        $this->queryColumns = implode(",", $this->columns);
    }


    public function insertMiniProgram($miniProgramProfile)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;

        $sql = 'insert into
                    sitePlugin(pluginId,
                     name, 
                     logo,
                     sort,
                     landingPageUrl,
                     landingPageWithProxy,
                     usageType,
                     loadingType,
                     permissionType,
                     authKey,
                     addTime)
                values
                    (:pluginId,
                    :name,
                    :logo,
                    :sort, 
                    :landingPageUrl,
                    :landingPageWithProxy,
                    :usageType, 
                    :loadingType, 
                    :permissionType,
                    :authKey,
                    :addTime);
                ';

        try {
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":pluginId", $miniProgramProfile["pluginId"]);
            $prepare->bindValue(":name", $miniProgramProfile["name"]);
            $prepare->bindValue(":logo", $miniProgramProfile["logo"]);
            $prepare->bindValue(":sort", $miniProgramProfile["sort"]);
            $prepare->bindValue(":landingPageUrl", $miniProgramProfile["landingPageUrl"]);
            $prepare->bindValue(":landingPageWithProxy", $miniProgramProfile["landingPageWithProxy"]);
            $prepare->bindValue(":usageType", $miniProgramProfile["usageType"]);
            $prepare->bindValue(":loadingType", $miniProgramProfile["loadingType"]);
            $prepare->bindValue(":permissionType", $miniProgramProfile["permissionType"]);
            $prepare->bindValue(":authKey", $miniProgramProfile["authKey"]);
            $prepare->bindValue(":addTime", $miniProgramProfile["addTime"]);
            $flag = $prepare->execute();
            $result = $prepare->rowCount();

            if ($flag && $result > 0) {
                return true;
            }

        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }

        return false;
    }


    public function updateProfile($data, $where)
    {
        return $this->updateInfo($this->tableName, $where, $data, $this->columns);
    }

    public function getMaxPluginId()
    {
        $tag = __CLASS__ . "_" . __FUNCTION__;
        $sql = "select max(pluginId) as pluginId from $this->tableName";

        try {
            $prepare = $this->db->prepare($sql);
            $flag = $prepare->execute();
            $result = $prepare->fetch(\PDO::FETCH_ASSOC);

            if ($flag && $result) {
                return $result['pluginId'];
            }
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, " error_msg = " . $e);
        }
        return $numbers = range(10000, 10000000000);
    }

    /**
     * get plugin by pluginId(not pk id)
     *
     * @param $pluginId
     * @return array|mixed
     */
    public function getPluginById($pluginId)
    {
        $tag = __CLASS__ . "_" . __FUNCTION__;
        try {
            $startTime = microtime(true);
            $sql = "select $this->queryColumns from $this->tableName where pluginId=:pluginId;";
            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":pluginId", $pluginId);
            $prepare->execute();
            $results = $prepare->fetch(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $pluginId, $startTime);
            return $results;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, " error_msg = " . $ex->getMessage());
            return [];
        }
    }

    /**
     * get plugin list by usageType
     *
     * @param $usageType
     * @param $permissionTypes
     * @return array
     */
    public function getPluginList($usageType, $permissionTypes)
    {
        $tag = __CLASS__ . "_" . __FUNCTION__;
        $startTime = microtime(true);
        try {

            $permissionTypes = implode(",", $permissionTypes);

            if ($usageType === Zaly\Proto\Core\PluginUsageType::PluginUsageNone) {
                $sql = "select $this->queryColumns from $this->tableName  
                        where 1!=:usageType and permissionType in (:permissionTypes) 
                        order by sort ASC, id DESC";
            } else {
                $sql = "select $this->queryColumns from $this->tableName 
                        where usageType=:usageType and permissionType in (:permissionTypes) 
                        order by sort ASC, id DESC";
            }

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->bindValue(":usageType", $usageType);
            $prepare->bindValue(":permissionTypes", $permissionTypes);
            $prepare->execute();
            $results = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $usageType, $startTime);

            return $results;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, " error_msg = " . $ex->getMessage());
            return [];
        }

    }

    public function getAllPluginList()
    {
        $tag = __CLASS__ . "_" . __FUNCTION__;
        $startTime = microtime(true);
        try {
            $sql = "select distinct pluginId,name,logo from $this->tableName order by id ASC;";

            $prepare = $this->db->prepare($sql);
            $this->handlePrepareError($tag, $prepare);
            $prepare->execute();
            $results = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, [], $startTime);

            return $results;
        } catch (Exception $ex) {
            $this->ctx->Wpf_Logger->error($tag, " error_msg = " . $ex->getMessage());
            return [];
        }

    }

}