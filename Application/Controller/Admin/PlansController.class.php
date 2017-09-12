<?php

class PlansController extends Controller
{
    /**
     * 美发套餐列表数据
     */
    public function plans()
    {
        //查询所有的数据
        $plansModel = D("plans");
        $row = $plansModel->plans();
        //dump($row);die;
        $this->assign('rows', $row);
        $this->display("plans");
    }

    /**
     * 添加套餐功能
     */
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            //显示添加表单
            $this->display("insert");

        } else {//添加功能
            //接收数据
            $post = $_POST;
            //处理数据
            $plansModel = D("plans");
            $rows = $plansModel->insert($post);
            //页面显示
            $this->success("index.php?p=Admin&c=Plans&a=plans");
        }
    }

    /**
     * 删除功能
     */
    public function delete(){
      //接收数据
      $plan_id=$_GET['plan_id'];
      //处理数据
        $plansModel=D("plans");
        $plansModel->delete($plan_id);
        //页面显示
        $this->success("index.php?p=Admin&c=Plans&a=plans");
    }
    /**
     * 套餐修改功能
     */
    public function update(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){//显示修改表单
            //接收数据
            $plan_id=$_GET['plan_id'];
            //回显数据,根据plan_id查询数据
            $plansModel=D("plans");
           $rows= $plansModel->select($plan_id);
           //var_dump($rows);die;
           $this->assign('rows',$rows);
        $this->display("update");

        }else{
            //接收数据
            $post=$_POST;
           // var_dump($post);die;
            //处理数据
            $plansModel=D("plans");
            $rows= $plansModel->update($post);
            if ($rows==false){
                $this->error("index.php?p=Admin&c=Plans&a=update","修改失败",3);
            }
           // var_dump($rows);die;
            //页面显示
            $this->success("index.php?p=Admin&c=Plans&a=plans");

        }

    }

}