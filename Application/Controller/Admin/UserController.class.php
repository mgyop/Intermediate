<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class UserController extends Controller
{
   public function index(){
       $UserModel = D('user');
       //获取条件
       $get = $_GET;
       //取得有效条件
       $where = $UserModel->serach($get);
       $page = $_GET['page'] ?? 1;
       //加入条件到分页中
       $rows= getPage('user',3,$page,5,'user_id desc',$where);
       //改装下搜索数据
       $serach=[];
       foreach ($get as $k=>&$v){
           if(!empty($v)){
               $serach[$k] = $v;
           }
       }
       //分配数据
       $this->assign('serach',$serach);
       $this->assign('rows',$rows);
       //展示页面
       $this->display('index');
   }
    /**
     * 根据id删除
     */
    public function delete(){
        $id = $_GET['id']??0;
        //创建员工模型
        $UserModel = D('user');
        $result = $UserModel->delOne($id);
        if($result){
            $this->success('index.php?p=Admin&c=User&a=index');
        }else{
            $this->error('index.php?p=Admin&c=User&a=index','删除失败',2);
        }
    }

    /**
     * 给会员充值金额
     */
    public function recharge(){
        $user_id = $_GET['id']??0;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //post 提交处理金额
            $post = $_POST;
            dump($post);die;
        }
        //get方式展示页面
        $this->assign('user_id',$user_id);
        $this->display('recharge');
    }
}