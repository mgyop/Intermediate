<?php

/**
 * Class IndentModel
 * 订单系统
 */
class IndentModel extends Model
{

    public function select()
    {
       $sql="select * from goodsorder";
       $rows=$this->db->fetchAll($sql);
       //var_dump($rows);die;
        return $rows;


    }
}