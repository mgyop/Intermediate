<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class IntegrateController extends PlatController
{
    public function index(){
        $page = $_GET['page'] ?? 1;
        //加入条件到分页中
        $rows= getPage('integrate',6,$page,5,'user_id desc','');
        //改装下搜索数据
        $this->assign('rows',$rows);
        $this->display('index');
    }
}