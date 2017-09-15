<?php

class OrderModel extends Model
{
    /**
     * @return array|null|void
     * 前台显示预约表单
     */
    public function order($page)
    {
        $y=3;
        //计算出总的条数
        $sql2="select count(*) from `order`";
        $zongtiao=$this->db->fetchColumn($sql2);//总条数
        $yeshu=ceil($zongtiao/$y);  //计算出总的页数
        //dump($yeshu);die;
        $page<1?1:$page;
        $page>$yeshu?$yeshu:$page;
        $x=($page-1)*$y;

        $page_s=($page-1)<1?1:($page-1);
        $page_x=($page+1)>$yeshu?$page:($page+1);

        $sql = "select * from `order` limit $x,$y";
        $order = $this->db->fetchAll($sql);
        //var_dump($order);die;
      if ($order==false){
          return false;
      }else {
            return ["page"=>$page,"yeshu"=>$yeshu,"zongtiao"=>$zongtiao,"order"=>$order,
            "page_s"=>$page_s,"page_x"=>$page_x
            ];
        }

        //return $this->getAll();
    }
    /**
     * @param $post 预约内容
     * @return bool
     * 预约功能
     */
    public function insert($post)
    {
        //var_dump($post);die;
        $date = strtotime($post['date']);//转成时间戳
       //dump(date("Y-m-d",$date)) ;die;
        $sql = "insert into `order` set phone='{$post['phone']}',
                realname='{$post['realname']}',
                barber='{$post['barber']}',
                content='{$post['content']}',
                date='{$date}'";
        $rows = $this->db->query($sql);
       //var_dump($rows);die;
        //die;
        if ($rows == false) {
            return false;
        }
        return true;
    }

    /**
     * @return array|bool|null|void
     * 查询员工数据
     */
    public function slect_member()
    {
        $sql = "select * from member";
        $member = $this->db->fetchAll($sql);
        //var_dump($rows);die;
        if ($member == false) {
            return false;
        }
        return $member;//返回所有员工的数据
    }

    /**
     * 根据员工id查询员工名字
     */

    public function member_id($barber)
    {
        $sql = "select * from member where member_id='{$barber}'";
        $member = $this->db->fetchRow($sql);
        //var_dump($rows);die;
        if ($member == false) {
            return false;
        }
        return $member;//根据id查询员工数据
    }

    /**
     * 后台预约查询所有数据
     */
    public function select($page)
    {
        $y=3;
        //计算出总的条数
        $sql2="select count(*) from `order` where status='3'";
        $zongtiao=$this->db->fetchColumn($sql2);//总条数
        $yeshu=ceil($zongtiao/$y);  //计算出总的页数并且向上取整
        //dump($yeshu);die;
        $page<1?1:$page;
        $page>$yeshu ? $yeshu:$page;
        $x=($page-1)*$y;
        $page_s=($page-1)<1?1:($page-1);
        $page_x=($page+1)>$yeshu?$page:($page+1);
        $sql = "select * from `order` where status='3' limit $x,$y";
        $order = $this->db->fetchAll($sql);
        //var_dump($sql);die;
        if ($order==false){
            return false;
        }else {
            return ["page"=>$page,"yeshu"=>$yeshu,"zongtiao"=>$zongtiao,"order"=>$order,
                "page_s"=>$page_s,"page_x"=>$page_x
            ];
        }
    }

    /**
     * @param $roder_id
     * 根据order_id处理状态
     */
    public function update($roder_id, $ty)
    {
        if ($ty == 1) {
            //这是同意的时候处理
            $sql = "update `order` set status=1 where order_id='{$roder_id}'";
            $rows = $this->db->query($sql);
            if ($rows == false) {
                return false;
            } else {
                return $rows;
            }

        }
    }
    //这是不同意的时候处理
    public function update_no($roder_id, $ty)
    {

        if ($ty == 2) {

            $sql = "update `order` set status=2 where order_id='{$roder_id}'";
            $rows = $this->db->query($sql);
            if ($rows == false) {
                return false;
            } else {
                return $rows;
            }
        }
    }

    /**
     * 将回复内容添加到数据库
     */
    public function reply($order_id, $reply)
    {
        //var_dump($roder_id,$reply);die;
        $sql = "update `order` set reply='{$reply}' where order_id='{$order_id}'";
        $this->db->query($sql);
    }
}