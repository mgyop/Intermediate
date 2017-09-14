<?php
class CodeController extends Base
{
    /**
     * 代金券相关功能控制器
     * 查询所有数据显示在表单中
     */
    public function select(){
        $codeModel = D("code");
        $code = $codeModel->select();
        $this->assign('codes', $code);

        $this->display("index");
    }
    /**
     * 删除代金券的功能
     */
    public function delete(){
        //接收id
        $code_id=$_GET['code_id'];
//        var_dump($code_id);die;
        $codeModel = D("code");
       $roes= $codeModel->delete($code_id);
       if ($roes==false){
           $this->redirect("index.php?p=Admin&c=Code&a=select");
       }
        //var_dump($code_id);die;
        $this->redirect("index.php?p=Admin&c=Code&a=select");
    }
    /**
     * 添加功能
     */

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            //显示添加表单
            $random_id=D("code");
            $random=$random_id->random();
            $this->assign("random_id",$random);
            $this->display("insert");
        } else {//添加功能
            //接收数据
            $post = $_POST;
           //var_dump($post);die;
            //处理数据
            $codeModel = D("code");
            $rows = $codeModel->insert($post);
           // var_dump($rows);die;
            //页面显示
            $this->success("index.php?p=Admin&c=Code&a=select");
        }
    }


}