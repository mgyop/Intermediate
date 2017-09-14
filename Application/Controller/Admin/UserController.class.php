<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class UserController extends Base
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
    public function edit(){
        //创建member模型
        $UserModel = D('user');
        //post 提交处理表单数据,保存修改
        if($_SERVER['REQUEST_METHOD'] ==="POST"){
            //接收表单数据
            $post = $_POST;
            //接收头像数据,处理头像
            $file = $_FILES['photo'];
            $UploadModel = new UploadModel();
            $path = $UploadModel->img_upload($file,'user_photo/');
            if( $path === false){
                $this->error("index.php?p=Admin&c=User&a=edit&id={$post['user_id']}",$UploadModel->getError(),2);
            }elseif($path != 1){
                $post['photo']=$path;
                $post['thumb_photo'] = $UploadModel->thumb($path,46,46);
            }
            //失败返回false
            $result = $UserModel->update($post);
            if($result === false){
                $this->error("index.php?p=Admin&c=User&a=index&edit={$post['user_id']}",$UserModel->getError(),2);
            }
            $this->success('index.php?p=Admin&c=User&a=index','修改成功',2);
        }else{
            //get方式提交回显数据
            //接收id
            $id = $_GET['id']??0;
            //根据id获取一条member数据
            $row = $UserModel->getOne($id);
            $this->assign('row',$row);
            $this->display('edit');
        }
    }
    /**
     * 根据id删除
     */
    public function delete(){
        $id = $_GET['id']??0;
        //创建员工模型
        $UserModel = D('user');
        //有记录的会员不能被删除
        $HistoryModel = D('history');
        $row = $HistoryModel->getUserData($id);
        if(!empty($row)){
            $this->error('index.php?p=Admin&c=User&a=index','我有记录,再删给你急',2);
        }
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
        //获取user模型
        $UserModel = D('user');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //post 提交处理金额
            $post = $_POST;
            //失败 返回 false
            $result = $UserModel->recharge($post);
            if(!$result){
                $this->error('index.php?p=Admin&c=User&a=recharge&id='.$post['user_id']);
            }else{
                //生成充值记录
                $HistoryModel = D('history');
                $insert_data = [];
                $insert_data['type'] = 0;
                $insert_data['user_id'] = $post['user_id'];
                $insert_data['member_id'] = 1;
                $insert_data['amount'] = $post['money'];
                $insert_data['content'] = "充值加薪";
                $insert_data['time'] = time();
                //获取会员的余额
                $money = $UserModel->getRemainder($post['user_id']);
                $insert_data['remainder'] = $money;
                //执行写入记录
                $HistoryModel->insert($insert_data);
                $this->success('index.php?p=Admin&c=User&a=index','充值成功',2);
            }
        }
        //get方式展示页面
        $user_id = $_GET['id']??0;
        //根据id获取数据
        $row = $UserModel->getOne($user_id);
        if(!$row){
            $this->error('index.php?p=Admin&c=User&a=index','会员不存在',2);
        }
        $this->assign('row',$row);
        $this->display('recharge');
    }

    /**
     * 会员的消费,根据套餐消费
     */
    public function expense(){
        //获取user模型
        $UserModel = D('user');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //处理消费业务
            $post = $_POST;
            //失败返回false
            $res = $UserModel->expense($post);
            if($res === false){
                $this->error("index.php?p=Admin&c=User&a=expense&id={$post['user_id']}",$UserModel->getError(),3);
            }
            //成功,跳回首页
            $this->success('index.php?p=Admin&c=User&a=index','消费成功',2);
        }else{
            //展示消费表单
               //>>获取会员id
               $user_id = $_GET['id']??0;
               //>>获取套餐数据
               $PlanModel = D('plan');
               $plan_data = $PlanModel->getAll();
               //分配套餐数据
            $this->assign('plan_data',$plan_data);

            //获取服务员工列表数据
            $MemberModel = D('member');
            $mem_data = $MemberModel->getAll();
            //获取部门数据
            $GroupModel = D('group');
            $group_data = $GroupModel->getAll();
            //改装group_data 加入员工数据
            $new_arr = [];
            foreach($group_data as $k=>&$v){
                foreach($mem_data as $k1=>$v1){
                    if($v['group_id'] == $v1['group_id']){
                        $new_arr[$v['name']][]= $v1;
                    }
                }
            }
            $this->assign('user_id',$user_id);
            $this->assign('new_arr',$new_arr);
            $this->display('expense');
        }
    }

}