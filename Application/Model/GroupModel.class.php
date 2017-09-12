<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 */
class GroupModel extends Model
{
    /**
     * 获取所有数据
     * @return array|null|void
     */
   public function getData(){
       return $this->getAll();
   }
}