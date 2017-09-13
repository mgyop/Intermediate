<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class HistoryModel extends Model
{
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
}