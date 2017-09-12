<?php
class PlansController extends Controller
{
    /**
     * 美发套餐列表数据
     */
    public function plans(){
        //查询所有的数据
        $manager=D("plans");
        $row= $manager->plans();
        //dump($row);die;
        $this->assign('rows',$row);
        $this->redirect("index.php?p=Admin&c=plans&a=plans");
    }
}