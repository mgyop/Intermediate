<?php


/**
 * Class MemberModel  员工模型
 */
class MemberModel extends Model
{
    private $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    protected $where = "";
    /**
     * 登录验证
     * @param $post
     * @return array|bool|mixed|null
     */
    public function login($post)
    {
        if(empty($post['username'])){
            $this->error = "请输入用户名";
            return false;
        }

        if(empty($post['password'])){
            $this->error = "请输入密码";
            return false;
        }

        /**
         * 验证登陆功能
         */
        $password = md5($post['password']);
        //非管理员不能登录
        $sql = "select * from member where username='{$post['username']}'and password='{$password}' and is_admin=1;";
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
    public function insert($data)
    {
        //密码为空不修改
        if(empty($data['password'])) {
            $this->error = "密码不能为空";
            return false;
        }else{
            //密码必须为数字字符串
            if (!is_numeric($data['password'])) {
                $this->error = "必须为数字";
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
        $sql = $this->setInsertSql($data);
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
        //密码加密
        $data['password'] = md5($data['password']);
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
        //部门id
        if(!empty($data['group_id'])){
            $this->arr_condition[] = "group_id='{$data['group_id']}'";
        }

        //username
        if(!empty($data['username'])){
            $this->arr_condition[] = "username='{$data['username']}'";
        }
        //realname
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

    public function delete($member_id){
        $rows = D('history')->db->fetchAll("select * from history where member_id={$member_id}");
//        dump($rows);
        if(!$rows){
            $this->delOne($member_id);
        }else{
            $this->error = "该员工有服务记录不能被删除...";
            return false;
        }
    }
}

