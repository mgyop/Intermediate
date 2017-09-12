<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 */
class IndexController extends Controller
{
    public function index(){
        //echo "后台首页";
        $this->display('login');
    }
    public function bar(){
        $this->display('bar');
    }
    public function top(){
        $this->display('top');
    }
    public function main(){
        $this->display('main');
    }
    public function order(){
        $this->display('order');
    }
    public function admin_list(){
        $this->display('admin_list');
    }
    public function revise_password(){
    $this->display('revise_password');
    }

    public function user_list(){
        $this->display('user_list');
    }
    public function add_user(){
        $this->display('add_user');
    }
    public function user_rank(){
        $this->display('user_rank');
    }
    public function user_message(){
        $this->display('user_message');
    }
    public function advertising_list(){
        $this->display('advertising_list');
    }
    public function basic_settings(){
        $this->display('basic_settings');
    }
    public function advertising(){
        $this->display('advertising');
    }

}