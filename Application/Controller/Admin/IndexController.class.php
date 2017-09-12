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
        $this->display('index');
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
}