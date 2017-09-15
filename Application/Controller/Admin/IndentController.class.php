<?php

/**
 * Class IndentController
 * 后台订单系统hc做
 */
class IndentController extends Controller
{
    /**
     * 查询订单表单数据显示在表单上
     * 显示订单表单
     */
    public function index(){
    //1.查询所有数据
      //创建一个对象帮我们完成
        $indentModel=D("Indent");
       $rows= $indentModel->select();
        $this->assign('rows',$rows);
        $this->display("index");





    }

}