<?php

/**
 * Class Base
 * 自动验证
 */
class Base extends Controller
{
    public function __construct()
    {
        //特例控制器,不用验证是否 登录:login,
        if(CONTROLLER_NAME != 'Login'){
            parent::__construct();
            //判断是否登录
            if(!isset($_SESSION['info'])){
                $this->redirect("?p=Admin&c=Login&a=login");
                die;
            }
        }
    }
}