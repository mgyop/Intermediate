<?php

class IndentController extends PlatController
{
    public function index(){
        /**
         * 前台订单页面显示
         */
        $indentMode = new IndentModel();
        $rows=$indentMode->home_indent();
        //var_dump($rows);die;
        $this->assign('rows',$rows);

        /**
         * 查询商品所有数据
         */
        // $indentMode = D("Indent");
        $goods = $indentMode->select_goods();
        //var_dump($goods);die;
        foreach ($goods as $key => $val) {
            $goods[$val['goods_id']] = $val;
            unset($val);
        }
        //var_dump($goods);die;
        $this->assign("goods", $goods);

        /**
         * 查询会员数据user表
         */
        // $indentMode = D("Indent");
        $rowss = $indentMode->select_user();

        foreach ($rowss as $key => $v) {
            $user_username[$v['user_id']] = $v;
            unset($v);
        }
        //var_dump($user_username);die;
        $this->assign('user', $user_username);


        $this->display("index");

    }

}