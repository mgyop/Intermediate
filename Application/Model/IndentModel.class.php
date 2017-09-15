<?php

/**
 * Class IndentModel
 * 订单系统
 */
class IndentModel extends Model
{   private $data=[];//将条件放入数组中
    private $dent='';//将以为数组转化为字符串放入数组中
    private $where="";

    public function select($page,$where)
    {
        //查询总条数
        $y=3;
        //计算出总的条数
        $sql2="select count(*) from goodsorder $where";
        $zongtiao=$this->db->fetchColumn($sql2);//总条数
        $yeshu=ceil($zongtiao/$y);  //计算出总的页数
        //dump($yeshu);die;
        $page<1?1:$page;
        $page>$yeshu?$yeshu:$page;
        $x=($page-1)*$y;

        $page_s=($page-1)<1?1:($page-1);
        $page_x=($page+1)>$yeshu?$page:($page+1);

        $sql = "select * from goodsorder $where limit $x,$y";
        $indent = $this->db->fetchAll($sql);
        //var_dump($order);die;
        if ($indent==false){
            $this->error="条件不存在";
            return false;
        }else {
            return ["page"=>$page,"yeshu"=>$yeshu,"zongtiao"=>$zongtiao,"indent"=>$indent,
                "page_s"=>$page_s,"page_x"=>$page_x
            ];
        }
    }
    public function index($get){
        /**
         * 拼装搜索条件
         */
        //var_dump($get);die;

        if (!empty($get['is_pay'])){
            $this->data[]="is_pay='{$get['is_pay']}'";
        }
        if (!empty($get['addr'])){
            $this->data[]="addr='{$get['addr']}'";
        }

        if(!empty($get['keyword'])){
            $this->data[]="(addr like '%{$get['keyword']}%' or order_num like '%{$get['keyword']}%')";
        }
        //将一维数组转化为字符串
        $this->dent=implode(" and ",$this->data);

        if (!empty($this->dent)){
            $this->where=" where ".$this->dent;
        }
       return $this->where;

    }

    /**
     * @return array
     * 查询订单的数据
     */
    public function select_indent(){
        $sql="select * from goodsorder";
        $rows=$this->db->fetchAll($sql);
        if ($rows==false){
            return false;
        }else{
            return $rows;
        }
    }
    /**
     * 查询会员表
     */
    public function select_user(){
        $sql="select * from `user`";
        $rowss=$this->db->fetchAll($sql);
       // var_dump($rowss);
            return $rowss;
    }
    /**
     * 查询商品数据
     */

    public function select_goods(){
        $sql="select * from goods";
        $goods=$this->db->fetchAll($sql);
        // var_dump($rowss);
        return $goods;
    }

    /**
     * 对发货进行操作
     */
    public function update_send($goodsordr_id){
        $sql="select * from goodsorder where goodsordr_id='{$goodsordr_id}'";
        $row=$this->db->fetchRow($sql);
        $row['is_send']=1;


      $sql="update goodsorder set is_send='{$row['is_send']}' where goodsordr_id='{$goodsordr_id}'";
     $rows=$this->db->query($sql);
    return $rows;
    }


}