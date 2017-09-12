<?php


/**
 * Class MemberModel  员工模型
 */
class MemberModel extends Model
{
    public $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    private $where='';
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
    public function insert($post)
    {
        $sql = $this->setInsertSql($post);
        return $this->db->query($sql);
    }

    public function update($data)
    {
        //密码为空不修改
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            //密码必须为数字字符串
            if (!is_numeric($data['password'])) {
                $this->error = "必须为数字";
            }
            if (count($data['password']) != 11) {
                $this->error = "手机号长度须为11位";
                return false;
            }
        }
        //用户名不能为空
        if (empty($data['username'])) {
            $this->error = "用户名不能为空";
            return false;
        }
        //姓名不能为空
        if (empty($data['realname'])) {
            $this->error = "姓名不能为空";
            return false;
        }
        //手机不能为空
        if (empty($data['realname'])) {
            $this->error = "手机不能为空";
            return false;
        }
        //准备sql
        $update_sql = $this->setUpdateSql($data, $data['member_id']);
        //执行
        return $this->db->query($update_sql);
    }
    /**
     * 执行修改last_loginip
     * @param $sql
     * @return bool|mysqli_result|void
     */
    public function editLoginIp($sql){
        return $this->db->query($sql);
    }/**
 * 查询
 * @param $data
 * @return string
 */
    public function serach($data){
//         dump($data);die;
        //分类id
        if(!empty($data['group_id'])){
            $this->arr_condition[] = "group_id='{$data['group_id']}'";
        }

        //username
        if(!empty($data['username'])){
            $this->arr_condition[] = "username='{$data['username']}'";
        }
        //status
        if(!empty($data['realname'])){
            $this->arr_condition[] = "realname='{$data['realname']}'";
        }
        //telephone
        if(!empty($data['realname'])){
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
}

