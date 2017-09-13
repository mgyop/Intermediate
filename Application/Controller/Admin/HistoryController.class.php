<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class HistoryController extends Controller
{
    /**
     * 充值和消费记录的查询
     */
    public function record(){
        $user_id = $_GET['user_id']??0;
        $HistoryModel = D('history');
        $get = $_GET;
        //取得有效条件
        $where = $HistoryModel->serach($get);
        $page = $_GET['page'] ?? 1;
        //加入条件到分页中
        $history_data= getPage('history',3,$page,5,'time desc',$where);
//        dump($history_data[1]);die;

        //获取会员信息分配到页面
        $UserModel = D('user');
        $user_data = $UserModel->getOne($user_id);
        $this->assign('user_data',$user_data);
        //获取员工表的数据并改装为员工id为键;
        $MemberModel = D('member');
        $mem_data = $MemberModel->getAll();
        //定义一个新的数组保存新数据
        $member_id_name = [];
        foreach($mem_data as $k=>$v){
            $member_id_name[$v['member_id']] = $v;
        }
        //分配员工数据到页面
        $this->assign('member_id_name',$member_id_name);
        //分配数据到页面
        $this->assign('history_data',$history_data);
        //获取服务员工列表数据
        $MemberModel = D('member');
        $mem_data = $MemberModel->getAll();
        //获取部门数据
        $GroupModel = D('group');
        $group_data = $GroupModel->getAll();
        //改装group_data 加入员工数据
        $new_arr = [];
        foreach($group_data as $k=>$v){
            foreach($mem_data as $k1=>$v1){
                if($v['group_id'] == $v1['group_id']){
                    $new_arr[$v['name']][]= $v1;
                }
            }
        }
        $this->assign('new_arr',$new_arr);
        //展示页面
        $this->display('record');
    }
}