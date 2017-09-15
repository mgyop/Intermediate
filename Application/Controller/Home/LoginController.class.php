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
            //处理数据
            $login = D("user");
            //var_dump($login);die;
            $rows = $login->login($post);
            //如果登陆失败
            if ($rows === false) {
                $this->error("index.php?p=Home&c=Login&a=login", "用户名或者密码错误", 3);
            }
            //密码正确保存到session中
            $_SESSION['user_userinfo'] = $rows;//sesssion在底层代码已打开
            if (isset($post['rememb_password'])) {//判断是否记住密码
                setcookie('user_id',$rows['user_id'],time()+60*60*7,'/','.vipmanager.com');
                setcookie('user_password',$rows['password'],time()+60*60*7,'/','.vipmanager.com');
            }

            $this->error("index.php?p=Home&c=Order&a=select");
        }

    }/**
 * 注册表单
 */
    public function register(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post = $_POST;
            $UserModel = D('user');
            //处理头像
            $UploadModel = new UploadModel();
            $path = $UploadModel->img_upload($_FILES['photo'],'user_photo/');
//            dump($path);die;
            if( $path === false){
                $this->error('index.php?p=Home&c=Login&a=register',$UploadModel->getError(),2);
            }elseif($path === 1){
                //默认头像
                $post['photo']=$this->path;
                $post['thumb_photo'] = $this->thumb_path;
            }else{
                $post['photo']=$path;
                $post['thumb_photo'] = $UploadModel->thumb($path,46,46);
            }

            $result = $UserModel->insert($post);
            if($result === false){
                $this->error('index.php?p=Home&c=Login&a=register',$UserModel->getError(),2);

            }
            $this->redirect('index.php?p=Home&c=Login&a=login');
        }
        $this->display('register');
    }

    /**
     * 退出登录
     * 清空session  和 cookie
     */
    public function logout(){
        setcookie('PHPSESSID',null,time()-1,'/','.vipmanager.com');
        session_unset();
        session_destroy();
        $this->redirect('index.php?p=Home&c=Login&a=login');

    }

}