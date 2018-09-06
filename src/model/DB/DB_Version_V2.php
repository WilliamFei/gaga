<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 04/09/2018
 * Time: 2:50 PM
 */

class DB_Version_V2 extends DB_Base
{
    public function __construct()
    {
        parent::__construct();
        $this->upgradeDB();
    }

    private  function upgradeDB()
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try{
            $sql = "alter table passportPassword add invitationCode VARCHAR(100)";
            $this->db->exec($sql);
        }catch (Exception $ex) {
            $this->wpf_Logger->error($tag, "error_msg ==" . $ex->getMessage());
        }
    }
}