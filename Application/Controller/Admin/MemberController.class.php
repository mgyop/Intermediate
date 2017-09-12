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
       $MemberModel->getAll();
   }
}