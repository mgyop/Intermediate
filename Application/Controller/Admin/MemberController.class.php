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
       //展示添加页面
       $this->display('add');
   }
   public function edit(){}
}