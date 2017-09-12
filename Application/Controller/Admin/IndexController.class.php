<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 */
class IndexController extends Controller
{
     public function index(){
         echo "我是首页";
         $MembersModel = D('members');//new MembersModel();
     }
}