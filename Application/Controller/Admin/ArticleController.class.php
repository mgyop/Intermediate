<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class ArticleController extends Controller
{
    /**
     * 添加活动
     */
   public function add(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
           dump($_POST);die;
       }
       //展示添加表单
       $this->display('add');
   }
}