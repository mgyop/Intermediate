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
        if(!isset($_SESSION['member_userinfo']) ){
            //>>2.cookie
            if( isset($_COOKIE['member_id']) && isset($_COOKIE['member_password'])){
                $MemberModel = D('member');
                $row = $MemberModel->getOne($_COOKIE['member_id']);
                if(!empty($row) && ($row['password'] == $_COOKIE['member_password']) ){
                    //有数据,而且相等
                    //保存session
                    $_SESSION['member_userinfo'] = $row;
                    return true;
                }
            }else{
                $this->redirect('?p=Admin&c=Login&a=login');
            }
        }else{
            //有session
            return true;
        }
    }
}