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
     * 根据 user_id 获取余额
     * @param $user_id
     * @return mix|mixed|null
     */
    public function getRemainder($user_id){
        $sql = "select money from user where user_id={$user_id}";
        $row = $this->db->fetchColumn($sql);
        return $row;
    }
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
        foreach($data as $k=>&$v){
            $data[$k] = htmlspecialchars($v);
        }
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
        $sql = $this->setInsertSql($data);
        $this->db->query($sql);
    }

    /**
     * 保存充值金额
     * @param $data
     */
    public function recharge($data){
        //获取充值规则
        $recharge_ruleModel = D('recharge_rule');
        $rule_sql = "select * from recharge_rule order by amount desc";
        $rules = $recharge_ruleModel->db->fetchAll($rule_sql);
        //充值有惊喜哦

        $money = $data['money'];
        //根据规则加上赠送金额
        foreach($rules as $v){
            if($money >= $v['amount']){
                $money += $v['donation'];
                break;
            }
            unset($v);
        }
        //准备sql
        $sql = "update user set money=money+'{$money}' where user_id='{$data['user_id']}'";
        return $this->db->query($sql);
    }
    public function expense($data){

        //根据user_id取得会员余额
        $user_data = $this->getOne($data['user_id']);
        //余额
        $money = $user_data['money'];

        //根据plan_id 获取套餐的价格
        $PlanModel = D('plan');
        $plan_data = $PlanModel->getOne($data['plan_id']);
        //套餐价格
        $price = $plan_data['money'];

        //根据是否是会员自动打折5折
        if($user_data['is_vip'] == 1){
            //打折后的消费金额
            $price = floor($price/2);
        }
        //在这里处理代金券
        $code = $data['code'];
        //根据code 取得代金券金额
        $CodeModel = D('code');
        $sql_code = "select * from code where code='{$code}' and status=1 and user_id={$data['user_id']}";
        $code_data = $CodeModel->db->fetchRow($sql_code);
        if($code_data == null ){
            $this->error = "代金券已使用";
            return false;
        }
//        dump($code_data);die;
        //代金券所指示金额
        $code_money = $code_data['money'];
        //代金券的金额小于套餐价格,抵消并更新代金券状态
        if($code_money <= $price){
            $price -= $code_money;
            //更新code状态
            $code_update_sql ="update code set money=0,status=0 where code_id={$code_data['code_id']}";
            $CodeModel->db->query($code_update_sql);
            unset($code_update_sql);
        }elseif($code_money > $price){
            $remainder = $code_money-$price;
            $code_update_sql ="update code set money={$remainder} where code_id={$code_data['code_id']}";
            $CodeModel->db->query($code_update_sql);
            $price = 0;
        }

        //可以消费,在这里更新余额
        //构建关联数组
        $money = $money-$price;
        //准备sql
        $sql = "update user set money='{$money}' where user_id={$data['user_id']}";
        //执行sql
        $result = $this->db->query($sql);
        if($result){ //执行成功,写历史记录
            //拼装关联数组,记录日志
            $history_data = [];
            $history_data['user_id'] = $data['user_id'];
            $history_data['member_id'] = $data['member_id'];
            $history_data['type'] = 1;
            $history_data['amount'] = $plan_data['money'];
            $history_data['content'] = $plan_data['des'];
            $history_data['time'] = time();
            $history_data['remainder'] = $money;
            //创建history模型
            $HistoryModel = D('history');
            //插入记录
            return $HistoryModel->insert($history_data);
        }
    }
    public function update($data){
        //去除xss
        foreach($data as $k=>&$v){
            $data[$k] = htmlspecialchars($v);
        }
        //用户名不能为空
        if(empty($data['username'])){
            $this->error = "用户名不能为空";
            return false;
        }
        //真实姓名不能为空
        if(empty($data['realname'])){
            $this->error = "真实姓名不能为空";
            return false;
        }
        //手机号码不能为空
        if(empty($data['telephone'])){
            $this->error = "手机号码不能为空";
            return false;
        }
        //密码为空不修改
        if(isset($data['password'])){
            if(empty($data['password'])){
                unset($data['password']);
            }
        }
        if(isset($data['repassword'])){
            //输入的密码不一致
            if($data['password'] != $data['repassword']){
                $this->error = "输入的密码不一致";
                return false;
            }
        }
        //删除data中的repassword;
        unset($data['repassword']);
        $data['password'] = md5($data['password']);
//        $sql = $this->setInsertSql($data);
        $user_id = array_shift($data);
        $sql = $this->setUpdateSql($data,$user_id);
        $this->db->query($sql);
    }
}