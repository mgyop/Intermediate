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

    /**
     * 菜单栏
     */
    public function menu(){
        $this->display('menu');
    }
    //顶部logo
    public function top(){
        $this->display('top');
    }
    //页面主体
    public function main()
    {
        $this->display('main');
    }
}