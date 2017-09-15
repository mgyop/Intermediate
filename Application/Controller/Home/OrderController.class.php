<?php

class OrderController extends PlatController
{
    /**
     * 查询预约数据并显示前台首页上
     */
    public function select()
    {
        /**
         * 查询预员工的数据
         */
        $memberModel = D("order");
        $row = $memberModel->slect_member();//查询出所有数据
        //var_dump($row);die;
        //获取id对应的名字
        foreach ($row as $key=>$v){
            $member[$v['member_id']]=$v;
        }
        //var_dump($member);die;
        //分配数据到首页前台预约中
        $this->assign('member',$member);

            //接收数据page计算出总条数和总页数
            $page=$_GET['page']??1;
            //查询所有的数据
            //var_dump($page);die;
            $orderModel = D("order");
            $row = $orderModel->order($page);//查询出所有数据
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
             * 查询员工数据,获取美发师的id
             */
            $OrderModel=D("order");
            $member=$OrderModel->slect_member();
            //var_dump($member);die;
            $this->assign('member',$member);//回显到添加表单中
            $this->display("insert");
           //var_dump($member);die;

        }else{
            //将预约数据保存到数据库
            //接收数据
            $post = $_POST;
           //var_dump($post);die;
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