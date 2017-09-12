<?php

/**
 * Class Base
 * 自动验证
 */
class Base extends Controller
{
    public function __construct()
    {
        //验证是否登录
        //>>1 session,没有session , 验证 cookie
        if(!isset($_SESSION['manager_info']) ){
            //>>2.cookie
            if( isset($_COOKIE['manager_id']) && isset($_COOKIE['manager_pass'])){
                $ManagerModel = new ManagerModel();
                $row = $ManagerModel->getOne($_COOKIE['manager_id']);
                if(!empty($row) && (md5($row['password']."itshop_") == $_COOKIE['manager_pass']) ){
                    //有数据,而且相等
                    //保存session
                    $_SESSION['manager_info'] = $row;
                    return true;
                }
            }else{
                $this->redirect('?p=Admin&c=Login&a=login');
                die;
            }
        }else{
            //有session
            return true;
        }
    }
}