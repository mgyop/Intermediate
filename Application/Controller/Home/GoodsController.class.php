<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsController extends Controller
{
    /**
     * 显示列表
     */
    public function index(){
        //获取所有数据
        $rows = D('goods')->getAll();
        $this->assign('rows',$rows);
        //获取用户信息
        $user_row = $_SESSION['user_userinfo'];
        $this->assign('user_row',$user_row);
        $this->display('index');
    }

    /**
     * 处理兑换
     */
    public function conversion(){
        $goods_id = $_GET['id'];
        //获取用户信息
        $user_row = $_SESSION['user_userinfo'];
        dump($user_row);die;
    }

}