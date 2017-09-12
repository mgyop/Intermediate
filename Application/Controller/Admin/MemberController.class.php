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
           $MemberModel = D('member');
           $sql = $MemberModel->setInsertSql($post);
           dump($sql);
           die;
       }
       //获取部门表数据
       $GroupModel = D('group');
       $data = $GroupModel->getData();
       dump($data);die;
       //展示添加页面
       $this->display('add');
   }
   public function edit(){}
}