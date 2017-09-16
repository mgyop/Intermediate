<?php

/**
 * Class IndentController
 * 后台订单系统hc做
 */
class IndentController extends Controller
{
    /**
     * 查询订单表单数据显示在表单上
     * 显示订单表单
     */
    public function index()
    {
        $get = $_GET;
        $this->assign('get',$get);
        //创建一个对象
        //1.查询所有数据
        //创建一个对象帮我们完成
        $page = $_GET['page']??1;
        $indentModel = D("Indent");
        $where = $indentModel->index($get);
        //var_dump($where);die;

        $rows = $indentModel->select($page, $where);
        //var_dump($rows);
        if ($rows == false) {
            $rows['indent'] = [];
        }
        $this->assign('rows', $rows);
        //查询订单所有数据 ,回显到搜索表单
        $indentMode = D("Indent");
        $row = $indentMode->select_indent();
        //var_dump($row);die;
        $this->assign('indent', $row);
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
        // var_dump($rowss);die;

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
        $this->display("index");
    }


    public function send()
    {
        //接收数据
        $goodsordr_id = $_GET['goodsordr_id'];
        // var_dump($goodsordr_id);
        $indentMode = new IndentModel();
        $indentMode->update_send($goodsordr_id);
        //var_dump($rows);die;
        $this->redirect("index.php?p=Admin&c=Indent&a=index");
    }


}