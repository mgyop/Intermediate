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
        $user_row = $_SESSION['user_userinfo']??'';
        $this->assign('user_row',$user_row);
        $this->display('index');
    }

    /**
     * 处理商品兑换
     */
    public function conversion(){
        if(!isset($_SESSION['user_userinfo'])){
            $this->error("index.php?p=Home&c=Goods&a=index",'未登录',2);
        }
        $goods_id = $_GET['id'];
        $addr = $_GET['addr'];
        //获取用户信息
        $user_row = $_SESSION['user_userinfo'];
        $GoodsModel = D('goods');
        //处理兑换,失败返回false
        $res = $GoodsModel->conversion($goods_id,$user_row,$addr);
        if($res === false){
            $this->error("index.php?p=Home&c=Goods&a=index",$GoodsModel->getError(),3);
        }
        $this->success("index.php?p=Home&c=Goods&a=index",$GoodsModel->getError(),3);
    }

}