<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class HistoryController extends Base
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
    /**
     * 获取排行榜
     */
    public function sort(){
        $HistoryModel = D('history');
        //获取排行榜信息
        $data = $HistoryModel->sort();
        //获取会员信息
        $rows = D('user')->getAll();
        //改装充值排行榜数据加入会员姓名
        foreach($data['res_recharge'] as $k=>&$v){
            foreach($rows as $k1=>$v1){
                if($v['user_id'] == $v1['user_id']){
                    $v['username'] = $v1['username'];
                }
            }
        }

        //改装消费排行榜数据加入会员姓名
        foreach($data['res_expense'] as $k=>&$v){
            foreach($rows as $k1=>$v1){
                if($v['user_id'] == $v1['user_id']){
                    $v['username'] = $v1['username'];
                }
            }
        }
        //获取会员信息
        $rows_member = D('member')->getAll();
        //修改服务排行榜

        foreach($data['res_member'] as $k=>&$v){
            foreach($rows_member as $k1=>$v1){
                if($v['member_id'] == $v1['member_id']){
                    $v['username'] = $v1['username'];
                }
            }
        }
        //展示页面
        $this->assign('data',$data);
        $this->display('sort');
    }
}