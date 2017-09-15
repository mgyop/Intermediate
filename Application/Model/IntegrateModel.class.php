<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class IntegrateModel extends Model
{
    /**
     * 获取会员积分记录
     * @param $user_id
     * @return array|null|void
     */
   public function getUserAll($user_id){
       $sql = "select * from integrate where user_id={$user_id}";
       return $this->db->fetchAll($sql);
   }

    /**
     * 插入积分消费记录
     * @param $data array 关联
     */
   public function setLog($data){
       $sql = $this->setInsertSql($data);
       return $this->db->query($sql);
   }
}