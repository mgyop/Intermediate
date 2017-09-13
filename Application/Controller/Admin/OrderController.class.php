<?php
class OrderController extends Controller
{

    /**
     * 处理预约状态
     */

    public function select(){
      //查询出所有未处理的状态

      $orderModel=D("order");
       $order= $orderModel->select();
      // var_dump($order);die;
       //回显到表单
        $this->assign("order",$order);
        //页面显示
        $this->display("order");
    }

}