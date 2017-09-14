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
        //取得会员信息
        $userData = D('user')->getAll();
        $new_userData = [];
        foreach($userData as $v){
            $new_userData[$v['user_id']] = $v;
            unset($v);
        }
        //该数据结构
        $this->assign('new_userData',$new_userData);
        $this->display("index");
    }
    public function getOneUserCodes()
    {
        $user_id = $_GET['user_id'];
        $codeModel = D("code");
        $code = $codeModel->getOneUserCodes($user_id);
        //展示页面
        $this->assign('code',$code);
        $this->display('show');
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
            $user_id = $_GET['user_id'];
            $this->assign('user_id',$user_id);
            //显示添加表单
            $random_id=D("code");
            $random=$random_id->random();
            $this->assign("random_id",$random);
            //取得会员信息
            $userData = D('user')->getAll();
            $this->assign('userData',$userData);
            $this->display("insert");
        } else {//添加功能
            //接收数据
            $post = $_POST;
           //var_dump($post);die;
            //处理数据
            $codeModel = D("code");
            $rows = $codeModel->insert($post);
            //页面显示
            $this->success("index.php?p=Admin&c=Code&a=select");
        }
    }


}