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
        $GoodsModel = D('goods');
        //获取条件
        $get = $_GET;
        //取得有效条件
        $where = $GoodsModel->serach($get);
        $page = $_GET['page'] ?? 1;
        //加入条件到分页中
        $rows= getPage('goods',3,$page,5,'goods_id desc',$where);
        //改装下搜索数据
        $serach=[];
        foreach ($get as $k=>&$v){
            if(!empty($v)){
                $serach[$k] = $v;
            }
        }
        //分配数据
        $this->assign('serach',$serach);
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
        $user_id = $_SESSION['user_userinfo']['user_id'];
        $user_row = D('user')->getOne($user_id);
        $GoodsModel = D('goods');
        //处理兑换,失败返回false
        $res = $GoodsModel->conversion($goods_id,$user_row,$addr);

        if($res === false){
            $this->error("index.php?p=Home&c=Goods&a=index",$GoodsModel->getError(),3);
        }
        $this->success("index.php?p=Home&c=Goods&a=index",$GoodsModel->getError(),3);
    }

}