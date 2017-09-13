<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class GroupController extends Controller
{
    /**
     * 部门列表页
     */
   public function index(){
       $GroupModel = D('group');
       $rows = $GroupModel->getAll();
       //分配数据
       $this->assign('rows',$rows);
       //展示页面
       $this->display('index');

   }

    /**
     * 添加部门
     */
   public function add(){
     if($_SERVER['REQUEST_METHOD'] === 'POST'){
         $GroupModel = D('group');
         $post = $_POST;
         //失败返回false
         $result = $GroupModel->insert($post);
         if($result){
             $this->success("index.php?p=Admin&c=Group&a=index",'添加成功',2);
         }
         $this->error("index.php?p=Admin&c=Group&a=add",$GroupModel->getError(),2);
     }
     $this->display('add');
   }

    /**
     * 修改部门
     */
   public function edit(){
       $GroupModel = D('group');
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $post = $_POST;
           $result = $GroupModel->update($post);
           if($result){
               $this->success("index.php?p=Admin&c=Group&a=index",'修改成功',2);
           }
           $this->error("index.php?p=Admin&c=Group&a=edit&id={$post['group_id']}",$GroupModel->getError(),2);
       }
       $group_id=$_GET['id'];
       //展示
       $row = $GroupModel->getOne($group_id);
       $this->assign('row',$row);
       $this->display('edit');
   }

    /**
     * 删除一条记录
     */
   public function delete(){
       $group_id = $_GET['id']??0;
       $GroupModel = D('group');
       $GroupModel->delete($group_id);
       $this->redirect("index.php?p=Admin&c=Group&a=index");

   }
}