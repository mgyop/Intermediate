<?php


class IndexController extends Controller
    {/**
     * Class IndexController
     *后台首页
     */
     public function index(){
         echo "我是首页";
         $MembersModel = D('members');//new MembersModel();
         $MembersModel->index();
     }
}