<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsorderModel extends Model
{
    private $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    private $where='';
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
    /**
     * 查询
     * @param $data
     * @return string
     */
    public function serach($data){
        //username
        if(!empty($data['user_id'])){
            $this->arr_condition[] = "user_id='{$data['user_id']}'";
        }
        //status
        if(!empty($data['realname'])){
            $this->arr_condition[] = "realname='{$data['realname']}'";
        }
        //telephone
        if(!empty($data['telephone'])){
            $this->arr_condition[] = "telephone='{$data['telephone']}'";
        }
        //keyword
        if(!empty($data['keyword'])){
            $this->arr_condition[] = "(username like '%{$data['keyword']}%' or realname like '%{$data['keyword']}%')";
        }
        $this->str_condition =implode(" and ",$this->arr_condition);
        if(!empty($this->str_condition)){
            $this->where = " where ".$this->str_condition;
        }
        return $this->where;
    }
}