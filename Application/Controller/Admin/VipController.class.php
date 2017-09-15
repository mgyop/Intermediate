<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class VipController extends Base
{
    /**
     * vip列表页
     */
    public function index(){
        $VipModel = D('vip');
        $rows = $VipModel->getAll();
        //分配数据
        $this->assign('rows',$rows);
        //展示页面
        $this->display('index');

    }

    /**
     * 添加vip级别
     */
    public function add(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $VipModel = D('vip');
            $post = $_POST;
            //失败返回false
            $result = $VipModel->insert($post);
            if($result){
                $this->success("index.php?p=Admin&c=vip&a=index");
            }
            $this->error("index.php?p=Admin&c=vip&a=add",$VipModel->getError(),2);
        }
        $this->display('add');
    }

    /**
     * 修改VIP级别
     */
    public function edit(){
        $VipModel = D('vip');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post = $_POST;
            $result = $VipModel->update($post);
            if($result){
                $this->success("index.php?p=Admin&c=vip&a=index",'修改成功',2);
            }
            $this->error("index.php?p=Admin&c=vip&a=edit&id={$post['group_id']}",$VipModel->getError(),2);
        }
        $vip_id=$_GET['id'];
        //展示
        $row = $VipModel->getOne($vip_id);
        $this->assign('row',$row);
        $this->display('edit');
    }

    /**
     * 删除一条记录
     */
    public function delete(){
        $vip_id = $_GET['id']??0;
        $GroupModel = D('vip');
        $GroupModel->delOne($vip_id);
        $this->redirect("index.php?p=Admin&c=Vip&a=index");

    }
}