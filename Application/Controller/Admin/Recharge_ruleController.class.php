<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class Recharge_ruleController extends Base
{
    /**
     * 赠送规则列表页
     */
    public function index(){
        $Recharge_ruleModel = D('recharge_rule');
        $rows = $Recharge_ruleModel->getAll();
        //分配数据
        $this->assign('rows',$rows);
        //展示页面
        $this->display('index');

    }
    /**
     * 增加赠送规则
     */
   public function add(){
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $post = $_POST;
          $Recharge_ruleModel = D('recharge_rule');
          $result = $Recharge_ruleModel->add($post);
          if($result === false){
              $this->error('index.php?p=Admin&c=Recharge_rule&a=add','添加失败',2);
          }
          $this->success('index.php?p=Admin&c=Recharge_rule&a=index');
      }else{
          $this->display('add');
      }

   }
    /**
     * 修改规则
     */
    public function edit(){
        $Recharge_ruleModel = D('recharge_rule');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $post = $_POST;
            $result = $Recharge_ruleModel->update($post);
            if($result){
                $this->success("index.php?p=Admin&c=recharge_rule&a=index",'修改成功',2);
            }
            $this->error("index.php?p=Admin&c=recharge_rule&a=edit&id={$post['id']}",$Recharge_ruleModel->getError(),2);
        }
        $id=$_GET['id'];
        //展示
        $row = $Recharge_ruleModel->getOne($id);
        $this->assign('row',$row);
        $this->display('edit');
    }

    /**
     * 删除一条记录
     */
    public function delete(){
        $id = $_GET['id']??0;
        $Recharge_ruleModel = D('recharge_rule');
        $Recharge_ruleModel->delOne($id);
        $this->redirect("index.php?p=Admin&c=recharge_rule&a=index");
    }
}