<?php
class CodeModel extends Model
{
    /**
     * @return array|bool|null|void
     * 查询所有代金券
     */
    public function select(){
        $sql = "select * from code";
        $code = $this->db->fetchAll($sql);
        //var_dump($rows);die;
        if ($code == false) {
            return false;
        }
        return $code;
    }

    /**
     * @param $code_id
     * @return bool|mysqli_result|void
     * 删除代金券功能
     */
    public function delete($code_id){
        //查询出对应的状态,未使用状态不能删除
        $sql="select * from code where code_id='{$code_id}'";
        $status=$this->db->fetchRow($sql);
        //var_dump($status);die;
            if ($status['status']==1){
                $this->error="未使用不能删除";
                return false;
            }else{

                $sql="delete from code where code_id='{$code_id}'";
                $code= $this->db->query($sql);
                //var_dump($rows);die;
                if ($code == false) {
                    return false;
                }else{
                    return $code;
                }
            }

    }

    /**
     * @param $post
     * @return array|mixed|null
     * 添加代金券
     */
    public function insert($post){
        //var_dump($post);die;
        $sql="insert into code set code='{$post['code']}',
                user_id='{$post['user_id']}',
                money='{$post['money']}'";
       $row=$this->db->fetchRow($sql);
        //var_dump($sql);die;
       if ($row==false){
           $this->serror="执行失败";
           return false;
       }else{
           return $row;
       }
    }
/**
 * 生成一个唯一ID
 */
    public function random(){
        $random_id="ID.".uniqid();
        return $random_id;
    }




}