<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/15
 */
class GoodsController extends Base
{
    /**
     * 添加商品
     */
    public function add(){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $post = $_POST;
          $GoodsModel = D('goods');
          //处理logo
          $file = $_FILES['logo'];
          $UploadModel = D('upload');
          $path = $UploadModel->img_upload($file,'goods_logo/');
          $post['logo'] = $path;
          //失败返回false
          $res = $GoodsModel->add($post);
          if($res === false){
              $this->error("?p=Admin&c=Goods&a=add",$GoodsModel->getError(),2);
          }
          $this->success("?p=Admin&c=Goods&a=index");
      }
      $this->display('add');
    }

    /**
     * 显示列表
     */
    public function index(){
        //获取所有数据
        $rows = D('goods')->getAll();
        $this->assign('rows',$rows);
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