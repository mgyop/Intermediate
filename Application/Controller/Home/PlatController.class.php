<?php

/**
 * Class Base
 * 自动验证
 */
class PlatController extends Controller
{
    public function __construct()
    {
        //验证是否登录
        //>>1 session,没有session , 验证 cookie
        if(!isset($_SESSION['user_userinfo']) ){
            //>>2.cookie
            if( isset($_COOKIE['user_id']) && isset($_COOKIE['user_password'])){
                $UserModel = D('user');
                $row = $UserModel->getOne($_COOKIE['user_id']);
                if(!empty($row) && ($row['password'] == $_COOKIE['user_password']) ){
                    //有数据,而且相等
                    //保存session
                    $_SESSION['user_userinfo'] = $row;
                    return true;
                }
            }else{
                $this->redirect('?p=Home&c=Login&a=login');
            }
        }else{
            //有session
            return true;
        }
    }
}