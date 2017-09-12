<?php

/**
 * Class IndexController
 * 会员后台登陆
 */
class LoginController extends Controller
{   //1.显示登陆页面
    public function login()
    {//index.php?p=Admin&c=Login&a=login
        // dump($_SERVER);DIE;
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->display("Login");
        } else {
            //验证登陆信息
            //接收数据
            $post=$_POST;
            dump($post);die;
            //处理数据
            //页面显示
        }


    }

}