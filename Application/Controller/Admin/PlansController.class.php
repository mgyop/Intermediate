<?php
class PlansController extends Controller
{
    /**
     * 美发套餐列表数据
     */
    public function plans(){
        //查询所有的数据
        $PlanSModel = D("plans");
        $rows= $PlanSModel->plans();
        $this->assign('rows',$rows);
        $this->display("plans");
    }
}