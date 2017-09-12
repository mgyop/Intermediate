<?php


/**
 * Class MemberModel  员工模型
 */
class MemberModel extends Model
{
    /**
     * 登录验证
     * @param $post
     * @return array|bool|mixed|null
     */
    public function login($post)
    {
        /**
         * 验证登陆功能
         */
        $password = md5($post['password']);
        $sql = "select * from member where username='{$post['username']}'and password='{$password}'";
        $rows = $this->db->fetchRow($sql);
        //dump($rows);die;
        if ($rows == false) {
            return false;
        } else {
            return $rows;
        }

    }

    /**
     * 插入一条记录
     * @param $post
     * @return bool|mysqli_result|void
     */
    public function insert($post){
        $sql = $this->setInsertSql($post);
        return $this->db->query($sql);
    }
    public function update($data){
        //用户名不能为空
        if(empty($data['username'])){
            $this->error = "用户名不能为空";
            return false;
        }
        //姓名不能为空
        if(empty($data['realname'])){
            $this->error = "姓名不能为空";
            return false;
        }
        //手机不能为空
        if(empty($data['realname'])){
            $this->error = "手机不能为空";
            return false;
        }
        dump($data);die;
    }

}

