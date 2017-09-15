<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class IntegrateModel extends Model
{
   public function getUserAll($user_id){
       $sql = "select * from integrate where user_id={$user_id}";
       return $this->db->fetchAll($sql);
   }
}