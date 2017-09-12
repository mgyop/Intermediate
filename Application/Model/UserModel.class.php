<?php

/**
 * 前台模板
 * Class UserModel
 */
class UserModel extends Model
{
    /**
     * 验证前台登陆信息
     */
    public function login($post){

        $password = md5($post['password']);
        $sql = "select * from users where username='{$post['username']}'and password='{$password}'";
        $rows = $this->db->fetchRow($sql);
        //dump($rows);die;
        if ($rows == false) {
            return false;
        } else {
            return $rows;
        }
    }

}