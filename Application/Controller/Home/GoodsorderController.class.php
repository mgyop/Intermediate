<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsorderController extends PlatController
{
    /**
     * 显示个人订单列表
     */
    public function index(){
        $user_id = $_SESSION['user_userinfo']['user_id'];
        //获取所有数据
        $rows = D('goodsorder')->getAllByUserId($user_id);
        $this->assign('rows',$rows);
        //获取会员信息
        $user_data = D('user')->getOne($user_id);
        //获取商品信息
        $goods_data = D('goods')->getAll();
        //改装
        $new_goods_data = [];
        foreach($goods_data as $v){
           $new_goods_data[$v['goods_id']] = $v;
        }
        $this->assign('new_goods_data',$new_goods_data);
        $this->assign('user_data',$user_data);
        $this->display('index');
    }
    /**
     * 修改商品
     */
    public function edit(){
        $GoodsModel = D('goods');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post = $_POST;
            //处理图片
            $file = $_FILES['logo'];
            $path = D('upload')->img_upload($file,'goods_logo/');

            if(!empty($path) && ($path!=1) ){  //已上传图片才修改
                $post['logo'] = $path;
            }
            //失败返回false
            $result = $GoodsModel->update($post);
            if($result){
                $this->success("index.php?p=Admin&c=goods&a=index",'修改成功',2);
            }
            $this->error("index.php?p=Admin&c=goods&a=edit&id={$post['goods_id']}",$GoodsModel->getError(),2);
        }
        $group_id=$_GET['id'];
        //展示
        $row = $GoodsModel->getOne($group_id);
        $this->assign('row',$row);
        $this->display('edit');
    }

    /**
     * 删除一条记录
     */
    public function delete(){
        $goods_id = $_GET['id']??0;
        $GoodsModel = D('goods');
        $GoodsModel->delete($goods_id);
        $this->redirect("index.php?p=Admin&c=goods&a=index");

    }

}