<?php

class OrderController extends Controller
{

    /**
     * 处理预约状态
     */

    public function select()
    {
        //查询出所有未处理的状态
        $orderModel = D("order");
        $order = $orderModel->select();
        // var_dump($order);die;
        //回显到表单
        $this->assign("order", $order);
        //页面显示
        $this->display("order");
    }

    /**
     * 处理状态,是否同意
     */
    public function update()
    {
        //接收数据
        $roder_id = $_GET['order_id'];
        $ty = $_GET['ty'];//ty==1时同意ty==0时不同意同意是自定义的
        //var_dump($ty);die;
        //处理数据
        if ($ty == 1) {
            $orderModer = D("order");
            $row = $orderModer->update($roder_id, $ty);
            // var_dump($row);die;
            //页面显示
            $this->success("index.php?p=Admin&c=Order&a=select");
        }

    }
    public function update_no(){
        $roder_id = $_GET['order_id'];
        $ty = $_GET['ty'];//ty==1时同意ty==2时不同意同意是自定义的
        //var_dump($_GET);die;
        if($ty == 2) {
            //不同意的处理
            $orderModer = D("order");
            $row = $orderModer->update_no($roder_id,$ty);
            //var_dump($row);die;
            $this->success("index.php?p=Admin&c=Order&a=select");
        }
    }
    /**
     * 回复操作
     */
    public function insert(){
       // var_dump($_SERVER);
        if ($_SERVER['REQUEST_METHOD']=='GET'){
            //显示回复表框
            //接收id
            $roder_id = $_GET['order_id'];
            //显示回复表单
            $this->assign('roder_id',$roder_id);
            $this->display("insert");
        }else{
            //接收数据
            $order_id=$_POST['roder_id'];
            $reply=$_POST['reply'];
            //var_dump($_POST);
            //处理数据,即添加回复数据
            $orderModer = D("order");
            $rows=$orderModer->reply($order_id,$reply);
          //  var_dump($rows);die;
            //页面显示
            $this->success("index.php?p=Admin&c=Order&a=select");
        }


    }

}