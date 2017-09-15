<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class VipModel extends Model
{
    /**
     * 添加记录
     * @param $data
     */
    public function insert($data){
        if(empty($data['vipname'])){
            $this->error = "vip等级不能为空";
            return false;
        }
        if(empty($data['recharge'])){
            $this->error = "充值金额不能为空";
            return false;
        }
        if(empty($data['discount'])){
            $this->error = "折扣不能为空";
            return false;
        }
        $sql = $this->setInsertSql($data);
        return $this->db->query($sql);
    }

    public function update($data){
        if(empty($data['vipname'])){
            $this->error = "vip等级不能为空";
            return false;
        }
        if(empty($data['recharge'])){
            $this->error = "充值金额不能为空";
            return false;
        }
        if(empty($data['discount'])){
            $this->error = "折扣不能为空";
            return false;
        }
        //获取vip_id
        $vip_id = array_shift($data);
        $sql = $this->setUpdateSql($data,$vip_id);
        return $this->db->query($sql);
    }

}