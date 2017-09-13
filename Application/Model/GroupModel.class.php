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

    /**
     * 插入一条数据
     * @param $data
     * @return bool|mysqli_result|void
     */
   public function insert($data){
       $sql = $this->setInsertSql($data);
       return $this->db->query($sql);
   }

    /**
     * 修改
     * @param $data
     * @return bool|mysqli_result|void
     */
   public function update($data){
       if(empty($data['name'])){
           $this->error = "部门名称不能为空";
           return false;
       }
       $sql = "update  `{$this->table}` set name='{$data['name']}' where group_id='{$data['group_id']}'";
       return $this->db->query($sql);
   }
   public function delete($id){
       $this->delOne($id);
   }
}