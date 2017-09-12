<?php

/**
 * Class IndexController
 * 会员后台登陆
 */
class LoginController extends Controller
{   //1.显示登陆页面
    public function login()
    {//login.php?p=Admin&c=Login&a=login
        // dump($_SERVER);DIE;
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->display("Login");
        } else {
            //验证登陆信息
            //接收数据
            $post = $_POST;
            //dump($post);die;
            //处理数据
            $login = D("member");
            //var_dump($login);die;
            $rows = $login->login($post);
            //var_dump($rows);die;
            //如果登陆失败
            if ($rows == false) {
                $this->error("index.php?p=Admin&c=Login&a=login", "用户名或者密码错误", 3);
            }
            //密码正确保存到session中
            $_SESSION['member_userinfo'] = $rows;//sesssion在底层代码已打开
            if (isset($post['bear'])) {//判断是否记住密码,保存cookie
                setcookie('member_id',$rows['member_id'],time()+60*60*7,'/','.vipmanager.com');
                setcookie('member_password',$rows['password'],time()+60*60*7,'/','.vipmanager.com');
            }
            $this->success("index.php?p=Admin&c=Index&a=index");
        }
    }

}