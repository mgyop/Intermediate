<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */

/**
 * 商品模型
 * Class GoodsModel
 */
class GoodsModel extends Model
{
    /**
     * 添加商品
     * @param $data
     * @return bool
     */
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

    /**
     * 修改商品
     * @param $data
     * @return bool|mysqli_result|void
     */
   public function update($data){
      $goods_id = array_shift($data);
      $sql = $this->setUpdateSql($data,$goods_id);
      return $this->db->query($sql);
   }

    /**
     * 商品的兑换
     * @param $goods_id
     * @param $user_row
     */
   public function conversion($goods_id,$user_row,$addr=''){
       //获取会员的积分
       $user_integrate = $user_row['integrate'];
       //获取商品的积分价格,库存
       $get_goods_sql = "select * from goods where goods_id={$goods_id}";
       $goods_data = D('goods')->db->fetchRow($get_goods_sql);
       //没有库存了
       if($goods_data['num'] == 0){
           $this->error = "商品库存不足";
           return false;
       }
       //积分不足
       if($user_integrate < $goods_data['price']){
           $this->error = "积分不够了";
           return false;
       }
       //执行兑换
           //开启事物
           $this->db->user_begin_transaction();
           //减库存
           $goods_update_sql = "update goods set num=num-1 where goods_id={$goods_id}";
           $res = $this->db->query($goods_update_sql);
           if(!$res){
               $this->error = "操作错误";
               //回滚
               $this->db->user_rollback();
               return false;
           }
           //减会员积分
           $user_update_sql = "update user set integrate=integrate-{$goods_data['price']} where user_id={$user_row['user_id']}";
           $user_res = D('user')->db->query($user_update_sql);
           if(!$user_res){
               $this->error = "操作失败";
               //回滚
               $this->db->user_rollback();
               return false;
           }

           //生成订单在这里完成
           //待完成.........
               //构造订单信息,生成订单
               $goodsorder_data = [];
               $goodsorder_data['user_id'] = $user_row['user_id'];
               $goodsorder_data['goods_id'] = $goods_data['goods_id'];
               $goodsorder_data['order_num'] = uniqid('goods_');
               $goodsorder_data['addr'] = $addr;
               $goodsorder_data['is_pay'] = 0;
               $goodsorder_data['is_send'] = 0;
               $goodsorder_data['time'] = time();
               //插入订单记录
                   $res_goods_order = D('goodsorder')->add($goodsorder_data);
                   if(!$res_goods_order){
                       $this->error = "下单失败";
                       $this->db->user_rollback();
                       return false;
                   }
           //兑换成功记录积分消费记录
               //构造消费记录的信息数组
               $log = [];
               $log['user_id'] = $user_row['user_id'];
               $log['type'] = 0;
               $log['intro'] = "- ".$goods_data['goods_name'];
               $log['integrate'] = $goods_data['price'];
               $log['time'] = time();
               $res = D('integrate')->setLog($log);
               if(!$res){
                   $this->error = "记录日志错误";
                   $this->db->user_rollback();
                   return false;
               }

           //成功提交事物
           $this->db->user_commit();
   }
}