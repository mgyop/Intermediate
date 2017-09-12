<?php


/**
 * Class MemberModel  员工模型
 */
class MemberModel extends Model
{
    public function login($post)
    {
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

}