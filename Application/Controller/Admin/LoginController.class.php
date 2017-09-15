<?php

/**
 * Class IndexController
 * 会员后台登陆
 */
class LoginController extends Controller
{   //1.显示登陆页面
    public function login()
    {//login.php?p=Admin&c=Login&a=login
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->display("Login");
        } else {
            //验证登陆信息
            //接收数据
            $post = $_POST;
           // var_dump($post['captcha']);die;
            //判断验证码是否正确
            if (!isset($post['captcha'])){
                $this->error("index.php?p=Admin&c=Login&a=login", "验证码不能为空", 2);
            }

            if ( $post['captcha']!=$_SESSION['muns']){//底层session已经开启了不需要在开启
                $this->error("index.php?p=Admin&c=Login&a=login", "验证码错误", 2);
            }

            //处理数据
            $login = D("member");
            $rows = $login->login($post);
            //如果登陆失败
            if ($rows == false) {
                $this->error("index.php?p=Admin&c=Login&a=login", "用户名或者密码错误", 2);
            }
            //密码正确保存到session中
            //修改最后登录ip
           // dump($_SERVER);die;
            $ip = getClientIP();
            $ip_int = ip2long($ip);
            //修改员工表 last_loginip
            $update_sql = $login->setUpdateSql(['last_loginip'=>$ip_int],$rows['member_id']);
            $login->editLoginIp($update_sql);
            $_SESSION['member_userinfo'] = $rows;//sesssion在底层代码已打开
            if (isset($post['bear'])) {//判断是否记住密码,保存cookie
                setcookie('member_id',$rows['member_id'],time()+60*60*7,'/','.vipmanager.com');
                setcookie('member_password',$rows['password'],time()+60*60*7,'/','.vipmanager.com');
            }
            $this->success("index.php?p=Admin&c=Index&a=index",'登录成功',2);
        }


    }

    /**
     * 退出登录
     * 清空session  和 cookie
     */
    public function logout()
    {
        //删除对应的session数据
        unset($_SESSION['member_userinfo']);
        $this->redirect('index.php?p=Admin&c=Login&a=login');
    }
}