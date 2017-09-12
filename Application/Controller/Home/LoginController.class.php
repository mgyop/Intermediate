<?php

class LoginController extends Controller
{

    /**
     * 验证前台的登陆密码
     *
     */
    public function Login(){
        //index.php?p=Home&c=Login&a=select;
        //接收数据
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->display("login");
        } else {
            //验证登陆信息
            //接收数据
            $post = $_POST;
            //dump($post);die;
            //dump($post);die;
            //处理数据
            $login = D("user");
            //var_dump($login);die;
            $rows = $login->login($post);
            //var_dump($rows);die;
            //如果登陆失败
            if ($rows === false) {
                $this->error("index.php?p=Home&c=Login&a=login", "用户名或者密码错误", 3);
            }
            //密码正确保存到session中
            $_SESSION['userinfo_q'] = $rows;//sesssion在底层代码已打开
            if (isset($post['rememb_password'])) {//判断是否记住密码
                $_COOKIE['user_id'] = $rows['user_id'];
                $_COOKIE['password'] = $rows['password'];
            }
            die;
            $this->error("index.php?p=Home&c=Login&a=");
        }

    }/**
 * 注册表单
 */
    public function register(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post = $_POST;
            $UserModel = D('user');
            $result = $UserModel->insert($post);
            if($result === false){
                $this->error('index.php?p=Home&c=Login&a=register',$UserModel->getError(),2);
                die;
            }
            $this->redirect('index.php?p=Admin&c=Login&a=login');
            die;
        }
        $this->display('register');
    }

    /**
     * 退出登录
     * 清空session  和 cookie
     */
    public function logout(){
        setcookie('PHPSESSID',null,time()-1,'/','.vipmanager');
        session_unset();
        session_destroy();
        $this->redirect('index.php?p=Home&c=Login&a=login');
        die;
    }

}