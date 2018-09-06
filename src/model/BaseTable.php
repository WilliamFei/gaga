<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 01/08/2018
 * Time: 4:46 PM
 */

class BaseTable
{
    /**
     * @var \PDO
     */
    public $db;
    /**
     * @var BaseCtx
     */
    public $ctx;

    public function __construct(Wpf_Ctx $context)
    {
        $this->ctx = $context;
        $this->db = $this->ctx->db;

        $this->init();
    }

    public function init()
    {

    }

    /**
     * 公用的插入方法，基本满足所有的插入状况
     * @param $tableName
     * @param $data
     * @param $defaultColumns
     * @return bool
     * @throws Exception
     */
    public function insertData($tableName, $data, $defaultColumns)
    {
        $startTime = microtime(true);
        $tag = __CLASS__ . "-" . __FUNCTION__;
        $insertKeys = array_keys($data);
        $insertKeyStr = implode(",", $insertKeys);
        $placeholderStr = "";
        foreach ($insertKeys as $key => $val) {
            if (!in_array($val, $defaultColumns)) {
                continue;
            }
            $placeholderStr .= ",:" . $val . "";
        }
        $placeholderStr = trim($placeholderStr, ",");
        if (!$placeholderStr) {
            throw new Exception("update is fail");
        }
        $sql = " insert into  $tableName({$insertKeyStr}) values ({$placeholderStr});";
        $prepare = $this->db->prepare($sql);
        $this->handlePrepareError($tag, $prepare);
        foreach ($data as $key => $val) {
            if (!in_array($key, $defaultColumns)) {
                continue;
            }
            $prepare->bindValue(":" . $key, $val);
        }
        $flag = $prepare->execute();
        $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, $data, $startTime);
        $count = $prepare->rowCount();
        if (!$flag || !$count) {
            throw new Exception("创建失败");
        }
        return true;
    }

    /**
     * 公用的更新方法，仅仅适用于and更新
     * @param $tableName
     * @param $where
     * @param $data
     * @param $defaultColumns
     * @return bool
     * @throws Exception
     */
    public function updateInfo($tableName, $where, $data, $defaultColumns)
    {
        $tag = __CLASS__ . "-" . __FUNCTION__;
        $startTime = microtime(true);
        $updateStr = "";
        $updateKeys = array_keys($data);
        foreach ($updateKeys as $updateField) {
            if (!in_array($updateField, $defaultColumns)) {
                continue;
            }
            $updateStr .= "$updateField=:$updateField,";
        }
        $updateStr = trim($updateStr, ",");
        if (!is_array($where)) {
            throw new Exception("update fail");
        }
        $whereKeys = array_keys($where);
        $whereKeyStr = "";
        foreach ($whereKeys as $k => $val) {
            if (!in_array($val, $defaultColumns)) {
                continue;
            }
            $whereKeyStr .= " $val=:$val and";
        }

        $whereKeyStr = trim($whereKeyStr, "and");

        if (!$whereKeyStr) {
            throw new Exception("update is fail");
        }

        $sql = "update  $tableName set  $updateStr where  $whereKeyStr";

        $prepare = $this->db->prepare($sql);
        $this->handlePrepareError($tag, $prepare);
        foreach ($data as $key => $val) {
            if (!in_array($updateField, $defaultColumns)) {
                continue;
            }
            $prepare->bindValue(":" . $key, $val);
        }

        foreach ($where as $key => $val) {
            $prepare->bindValue(":$key", $val);
        }
        $this->ctx->Wpf_Logger->writeSqlLog($tag, $sql, ["data" => $data, "where" => $where], $startTime);
        $flag = $prepare->execute();
        $count = $prepare->rowCount();
        if (!$flag || !$count) {
            throw new Exception("update is fail");
        }
        return true;
    }

    public function handlePrepareError($tag, $prepare)
    {
        if (!$prepare) {
            $error = [
                "error_code" => $this->db->errorCode(),
                "error_info" => $this->db->errorInfo(),
            ];
            $this->ctx->Wpf_Logger->error($tag, json_encode($error));
            throw new Exception("execute prepare fail" . json_encode($error));
        }

    }

    protected function getCurrentTimeMills()
    {
        return $this->ctx->ZalyHelper->getMsectime();
    }

}