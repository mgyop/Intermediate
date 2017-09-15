<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsorderModel extends Model
{
    /**
     * 在兑换中添加订单
     * @param $data
     * @return bool|mysqli_result|void
     */
   public function add($data){
       $sql = $this->setInsertSql($data);
       return $this->db->query($sql);
   }
    /**
     * 获取指定用户的订单记录
     * @param $user_id
     */
   public function getAllByUserId($user_id){
       $sql = "select * from goodsorder where user_id={$user_id}";
       return $this->db->fetchAll($sql);
   }
}