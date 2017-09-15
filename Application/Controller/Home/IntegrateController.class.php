<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class IntegrateController extends PlatController
{
    public function index(){
        $rows = D('integrate')->getUserAll($_SESSION['user_userinfo']['user_id']);
        $this->assign('rows',$rows);
        $this->display('index');
    }
}