<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsModel extends Model
{
   public function add($data){
       //判断
       if(empty($data['goods_name'])){
           $this->error = "商品名称不能为空";
           return false;
       }
       if(empty($data['price'])){
           $this->error = "商品价格不能为空";
           return false;
       }
       $sql = $this->setInsertSql($data);
       $this->db->query($sql);
   }
   public function update($data){
      $goods_id = array_shift($data);
      $sql = $this->setUpdateSql($data,$goods_id);
      return $this->db->query($sql);
   }
}