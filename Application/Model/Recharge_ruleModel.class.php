<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class Recharge_ruleModel extends Model
{
    public function add($data){
        $sql = $this->setInsertSql($data);
        if(empty($data['amount'])){
            $this->error ="充值金额不能为空";
            return false;
        }
        if(empty($data['donation'])){
            $this->error ="赠送金额不能为空";
            return false;
        }
        $this->db->query($sql);
    }

    /**
     * 修改
     * @param $data
     * @return bool
     */
    public function update($data){
        if(empty($data['amount'])){
            $this->error ="充值金额不能为空";
            return false;
        }
        if(empty($data['donation'])){
            $this->error ="赠送金额不能为空";
            return false;
        }
        $recharge_rule_id = array_shift($data);
        $sql = $this->setUpdateSql($data,$recharge_rule_id);
        return $this->db->query($sql);
    }
}