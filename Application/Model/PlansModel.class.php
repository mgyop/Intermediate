<?php
class plansModel extends Model
{
    /**
     * 美发套餐查询所有数据
     */
    public function plans(){
        return $this->getAll();
    }
    public function insert($post){
        $sql="insert into plans set name='{$post['name']}',
                des='{$post['des']}',
                money='{$post['money']}',
                status='{$post['status']}'";
       $rows= $this->db->fetchRow($sql);
        return $rows;
    }

    /**
     * 删除套餐功能
     */
    public function delete($plan_id){
        $sql="delete from plans where plan_id='{$plan_id}'";
        $this->db->query($sql);
    }

    /**
     * 修改套餐回显数据
     */
    public function select($plan_id){
        //根据id查询数据
        $sql="select * from plans where plan_id='{$plan_id}'";
        $rows=$this->db->fetchRow($sql);
        if ($rows==false){
            return false;
        }
        return $rows;
    }
    public function update($post){
       $sql="update plans set name='{$post['name']}',des='{$post['des']}',
          money='{$post['money']}',
          status='{$post['status']}'
          where plan_id='{$post['plan_id']}'";
          $rows=$this->db->query($sql);
          if ($rows==false){
              return false;
          }
          return true;
          //var_dump($rows);die;
    }


}