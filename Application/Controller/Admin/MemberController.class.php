<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 */
class MemberController extends Controller
{
    /**
     * 员工列表
     */
   public function index(){
       $MemberModel = D('member');
       $rows = $MemberModel->getAll();
       //分配数据
       $this->assign('rows',$rows);
       //展示页面
       $this->display('index');
   }

    /**
     * 添加员工
     */
   public function add(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
           //post 提交处理表单
           $post = $_POST;
//           dump($_FILES);die;
           //处理头像
           $UploadModel = new UploadModel();
           $path = $UploadModel->img_upload($_FILES['photo'],'member_photo/');
           if( $path === false){
               $this->error('index.php?p=Admin&c=Member&a=add',$UploadModel->getError(),2);
           }elseif($path === 1){
               //默认头像
               $post['photo']=$this->path;
               $post['thumb_photo'] = $this->thumb_path;
               die;
           }else{
               $post['photo']=$path;
               $post['thumb_photo'] = $UploadModel->thumb($path,46,46);
           }

           //创建员工模型
           $MemberModel = D('member');
           $result = $MemberModel->insert($post);
           if($result){
               $this->success('index.php?p=Admin&c=Member&a=index','添加成功',2);
           }
           $this->error('index.php?p=Admin&c=Member&a=add','添加失败',2);
       }
       //获取部门表数据
       $GroupModel = D('group');
       $data = $GroupModel->getData();
       //分配数据
       $this->assign('data',$data);
       //展示添加页面
       $this->display('add');
   }

    /**
     * 根据id删除
     */
   public function delete(){
       $id = $_GET['id']??0;
       //创建员工模型
       $MemberModel = D('member');
       $result = $MemberModel->delOne($id);
       if($result){
          $this->success('index.php?p=Admin&c=Member&a=index');
       }else{
          $this->error('index.php?p=Admin&c=Member&a=index','删除失败',2);
       }
   }
   public function edit(){
       //接收id
       $id = $_GET['id']??0;
       //创建member模型
       $MemberModel = D('member');
       //post 提交处理表单数据,保存修改
       if($_SERVER['REQUEST_METHOD'] ==="POST"){
           //接收表单数据
           $post = $_POST;
           //接收头像数据,处理头像
           $file = $_FILES['photo'];
           $UploadModel = new UploadModel();
           $path = $UploadModel->img_upload($file,'member_photo/');
           if( $path === false){
               $this->error("index.php?p=Admin&c=Member&a=edit&id={$post['member_id']}",$UploadModel->getError(),2);
           }elseif($path === 1){
               //不修改
           }else{
               $post['photo']=$path;
               $post['thumb_photo'] = $UploadModel->thumb($path,46,46);
           }
           //失败返回false
           $result = $MemberModel->update($post);
           if($result === false){
               $this->error('index.php?p=Admin&c=Member&a=index&id={$id}',$MemberModel->getError(),2);
           }
           $this->success('index.php?p=Admin&c=Member&a=index','修改成功',2);
       }
       //get方式提交回显数据
       //根据id获取一条member数据
       $row = $MemberModel->getOne($id);
       //分配数据
       $this->assign('row',$row);
       //获取部门表数据
       $GroupModel = D('group');
       $data = $GroupModel->getData();
       //分配数据
       $this->assign('data',$data);
       //展示页面
       $this->display('edit');
   }
}