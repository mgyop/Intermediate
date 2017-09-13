<?php

/**
 * 前台模板
 * Class UserModel
 */
class UserModel extends Model
{
    private $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    private $where='';
    /**
     * 验证前台登陆信息
     */
    public function login($post){

        $password = md5($post['password']);
        $sql = "select * from user where username='{$post['username']}'and password='{$password}'";
        $rows = $this->db->fetchRow($sql);
        //dump($rows);die;
        if ($rows == false) {
            return false;
        } else {
            return $rows;
        }
    }
    /**
     * 查询
     * @param $data
     * @return string
     */
    public function serach($data){
        //username
        if(!empty($data['username'])){
            $this->arr_condition[] = "username='{$data['username']}'";
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
    /**
     * 插入一条数据
     * @param $data
     */
    public function insert($data){
        dump($data);
        foreach($data as $k=>&$v){
            $data[$k] = htmlspecialchars($v);
        }
        dump($data);
        if(empty($data['username'])){
            $this->error = "用户名不能为空";
            return false;
        }
        if(empty($data['realname'])){
            $this->error = "真实姓名不能为空";
            return false;
        }
        if(empty($data['telephone'])){
            $this->error = "手机号码不能为空";
            return false;
        }
        if(empty($data['password'])){
            $this->error = "密码不能为空";
            return false;
        }
        if($data['password'] != $data['repassword']){
            $this->error = "输入的密码不一致";
            return false;
        }
        //删除data中的repassword;
        unset($data['repassword']);
        $data['password'] = md5($data['password']);
        echo 1;
        $sql = $this->setInsertSql($data);
        echo $sql;
        $this->db->query($sql);
    }

    /**
     * 保存充值金额
     * @param $data
     */
    public function recharge($data){
        //准备sql
        $sql = "update user set money=money+'{$data['money']}' where user_id='{$data['user_id']}'";
        return $this->db->query($sql);
    }
}