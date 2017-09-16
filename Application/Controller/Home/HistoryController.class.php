<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 */
class HistoryController extends PlatController
{
    /**
     * 获取排行榜
     */
    public function home_sort(){
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
        $this->display('home_sort');
    }
}