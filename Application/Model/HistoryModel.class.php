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

    /**
     * 获取排行榜
     */
    public function sort(){
        //获取充值排行榜
        $sql_r = "select sum(amount) as money,user_id from `history` where type=0 group by user_id order by money desc limit 3";
        $res_recharge = $this->db->fetchAll($sql_r);
        //获取消费排行榜
        $sql_r = "select sum(amount) as money,user_id from `history` where type=1 group by user_id order by money desc limit 3";
        $res_expense = $this->db->fetchAll($sql_r);

        //获取服务排行榜
        $sql_m = "select count(member_id) as count,member_id from `history` group by member_id order by count desc limit 3";
        $res_member = $this->db->fetchAll($sql_m);
        return ['res_recharge'=>$res_recharge,'res_expense'=>$res_expense,'res_member'=>$res_member];
    }
}