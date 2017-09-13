<?php
class OrderModel extends Model
{
    /**
     * @return array|null|void
     * 显示预约表单
     */
    public function order(){
        return $this->getAll();
    }

    /**
     * @param $post 预约内容
     * @return bool
     * 预约功能
     */
    public function insert($post){
            $date=strtotime($post['date']);
        $sql="insert into `order` set phone='{$post['phone']}',
                realname='{$post['realname']}',
                barber='{$post['barber']}',
                content='{$post['content']}',
                date='{$date}'";
        $rows= $this->db->query($sql);
        //var_dump($sql);
        //die;
        if ($rows==false){
            return false;
        }
        return true;
    }

    /**
     * @return array|bool|null|void
     * 查询员工数据
     */
    public function slect_member(){
        $sql="select * from member";
        $member= $this->db->fetchAll($sql);
       //var_dump($rows);die;
        if ($member==false){
            return false;
        }
        return $member;//返回所有员工的数据
    }
    /**
     * 根据员工id查询员工名字
     */

    public function member_id($member2){
        $sql="select * from member where member_id='{'$member2'}'";
        $member= $this->db->fetchRow($sql);
        //var_dump($rows);die;
        if ($member==false){
            return false;
        }
        return $member;//根据id查询员工数据
    }

    /**
     * 后台预约查询所有数据
     */
    public function select(){

        $sql="select * from `order` where status=3";
        $order= $this->db->fetchAll($sql);
        //var_dump($order);die;
        if ($order==false){//3表示未处理状态 1成功2失败
        return false;//查询出所有未处理的数据
        }else{
            return $order;
        }

    }
}