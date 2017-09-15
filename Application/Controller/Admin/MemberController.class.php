<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 */
class MemberController extends Base
{
    /**
     * 员工列表
     */

   public function index(){

       $GroupModel = D('group');
       $MemberModel = D('member');
       //获取条件
       $get = $_GET;
       //取得有效条件
       $where = $MemberModel->serach($get);
       $page = $_GET['page'] ?? 1;
       //加入条件到分页中
       $rows= getPage('member',3,$page,5,'member_id desc',$where);
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
       //获取部门表数据
       $GroupData = $GroupModel->getData();
       $group_data = [];
       //改装部门数据
       foreach($GroupData as $k=>$v){
           $group_data[$v['group_id']] = $v;
       }
       //分配数据
       $this->assign('GroupData',$group_data);
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
           //处理头像
           $UploadModel = new UploadModel();
           $path = $UploadModel->img_upload($_FILES['photo'],'member_photo/');
           if( $path === false){
               $this->error('index.php?p=Admin&c=Member&a=add',$UploadModel->getError(),2);
           }elseif($path === 1){
               //默认头像
               $post['photo']=$this->path;
               $post['thumb_photo'] = $this->thumb_path;
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
           }elseif($path != 1){
               $post['photo']=$path;
               $post['thumb_photo'] = $UploadModel->thumb($path,46,46);
           }
           //失败返回false
           $result = $MemberModel->update($post);
           if($result === false){
               $this->error("index.php?p=Admin&c=Member&a=index&edit={$post['member_id']}",$MemberModel->getError(),2);
           }
           $this->success('index.php?p=Admin&c=Member&a=index','修改成功',2);
       }
       //get方式提交回显数据
       //接收id
       $id = $_GET['id']??0;
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