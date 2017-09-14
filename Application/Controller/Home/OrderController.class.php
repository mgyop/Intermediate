<?php

class OrderController extends Controller
{

    /**
     * 查询预约数据并显示前台首页上
     */
    public function select()
    {
        //接收数据page计算出总条数和总页数
        $page=$_GET['page'];
        //查询所有的数据
        //var_dump($page);die;
        $orderModel = D("order");
        $row = $orderModel->order($page);
        //dump($row);die;


//       foreach ($row as &$value){
//            $value['status']==1?($value['status']="成功"):($value['status']==2?($value['status']="失败"):$value['status']='未处理');
//        }
       // dump($row);die;
        $this->assign('rows', $row);


        $this->display("index");
    }

    /**
     * 预约美发师功能
     */
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {//显示预约添加表单
            /**
             * 查询员工数据
             */
            $OrderModel=D("order");
            $member=$OrderModel->slect_member();
            $this->assign('member',$member);
            $this->display("insert");
           //var_dump($member);die;
            /**
             * 根据member_id查询员工名字
             */
             $member2=$member['member_id'];
            $OrderModel=D("order");
            $member_id=$OrderModel->member_id($member2);
            $this->assign('member_id',$member_id);

        }else{
            //将预约数据保存到数据库
            //接收数据
            $post = $_POST;
           // var_dump($post);die;
            $orderModel = D("order");
            $row = $orderModel->insert($post);
           // var_dump($row);die;
            if ($row == false) {
                $this->error("index.php?p=Home&c=Order&a=insert", "提交预约失败", 2);
            }
            $this->success("index.php?p=Home&c=Order&a=select");
        }

    }
}