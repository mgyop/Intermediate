<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class ArticleModel extends Model
{
    private $arr_condition = [];  //保存条件
    private $str_condition = '';  //保存拼接过后的字符串
    protected $where = "";
    public function add($data){
        //数据完整性判断
        if(empty($data['title'])){
            $this->error = "活动名称不能为空";
            return false;
        }

        if(empty($data['content'])){
            $this->error = "活动内容不能为空";
            return false;
        }

        if(empty($data['start'])){
            $this->error = "活动开始时间不能为空";
            return false;
        }
        if(empty($data['end'])){
            $this->error = "活动结束时间不能为空";
            return false;
        }
        $data['start'] = strtotime($data['start']);
        $data['end'] = strtotime($data['end']);
        if($data['start'] >= $data['end']){
            $this->error = "活动开始日期需小于结束日期";
            return false;
        }
        //获取活动发布时间
        $data['time'] = time();
        $isert_sql = $this->setInsertSql($data);
        return $this->db->query($isert_sql);
    }

    /**
     * 修改
     * @param $data
     * @return bool
     */
    public function update($data){
        //数据完整性判断
        if(empty($data['title'])){
            $this->error = "活动名称不能为空";
            return false;
        }
        if(empty($data['content'])){
            $this->error = "活动内容不能为空";
            return false;
        }

        if(empty($data['start'])){
            $this->error = "活动开始时间不能为空";
            return false;
        }
        if(empty($data['end'])){
            $this->error = "活动结束时间不能为空";
            return false;
        }
        $data['start'] = strtotime($data['start']);
        $data['end'] = strtotime($data['end']);
        if($data['start'] >= $data['end']){
            $this->error = "活动开始日期需小于结束日期";
            return false;
        }
        //取出article_id;
        $article_id = array_shift($data);
        $sql = $this->setUpdateSql($data,$article_id);
        return $this->db->query($sql);
    }
/** 查询
* @param $data
* @return string
*/
    public function serach($data){
//         dump($data);die;
        //部门id
        if(!empty($data['article_id'])){
            $this->arr_condition[] = "group_id='{$data['group_id']}'";
        }

        //keyword
        if(!empty($data['keyword'])){
            $this->arr_condition[] = "(username like '%{$data['keyword']}%' or realname like '%{$data['keyword']}%')";
        }
        $this->str_condition =implode(" and ",$this->arr_condition);
        if(!empty($this->str_condition)){
            $this->where = " where ".$this->str_condition;
        }
        return $this->where;
    }
    public function end($article_id){
        $sql = "update article set end=0 where article_id={$article_id} ";
        $this->db->query($sql);
    }
}