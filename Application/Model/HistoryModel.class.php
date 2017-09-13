<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class HistoryModel extends Model
{
    private $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    private $where='';
    /**
     * 自动记录充值消费记录
     * @param $data
     */
   public function insert($data){
       //生成sql语句
       $sql = $this->setInsertSql($data);
       //执行sql
       return $this->db->query($sql);
   }

    /**
     * 根据会员id查询记录
     * @param $id
     * @return array|null|void
     */
   public function getUserData($id){
       $sql = "select * from `history` where user_id={$id} ";
       return $this->db->fetchAll($sql);
   }
    /**
     * 查询
     * @param $data
     * @return string
     */
    public function serach($data){
        //username
        if(!empty($data['member_id'])){
            $this->arr_condition[] = "member_id='{$data['member_id']}'";
        }
        $this->str_condition =implode(" and ",$this->arr_condition);
        if(!empty($this->str_condition)){
            $this->where = " where ".$this->str_condition;
        }
        return $this->where;
    }
}