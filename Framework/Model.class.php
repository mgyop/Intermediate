<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 10:46
 */
abstract class Model
{
    protected $table;   //保存表名
    //可以让继承提交中的类都使用该属性.
    protected $db;

    //存放错误信息
    protected  $error;

    public function __construct()
    {
        $this->db = DB::getInstance($GLOBALS['config']['db']);
        //初始化表名
        $this->getTableName();
    }


    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(){
        return $this->error;
    }

    /**
     * 获取表名
     * @return string tableName
     */
    private function getTableName(){
        $className = get_class($this); //获取类名
        $tableName = strtolower(str_replace('Model','',$className)); //获取表名
        $this->table = $tableName; //保存表名
    }

    /**
     * 根据id删除一条记录
     * @param int $id
     * @return int
     */
    public function delOne(int $id){
        $column = $this->table."_id";
        $this->db->query("delete from `{$this->table}` where {$column}={$id}");
        return $id;
    }

    /**
     * 根据id查询一条记录,适用于修改 回显
     * @param $id
     * @return array|mixed|null
     */
    public function getOne($id){
        //获取列名
        $column = $this->table."_id";
        //sql 准备
        $sql = "select * from `{$this->table}` where {$column}=$id";
        return $this->db->fetchRow($sql);
    }

    /**
     * 获取所有数据
     * @return array|null|void
     */
    public function getAll($id=0){
        $where = "";
        if($id != 0){
            $column = $this->table."_id";
            $where = " where {$column}={$id}";
        }
        $sql = "select * from `{$this->table}` {$where}";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    /**
     * 生成update语句
     * @param $arr  关联数组
     * @return string $sql
     */
    public function setUpdateSql($arr,$id){
        //获取列名
        $column = $this->table."_id";
        $sql = "update `{$this->table}` set ";
        foreach($arr as $k=>$v){
            $new_arr[] ="{$k}='{$v}'";
        }
        $str  = implode(',',$new_arr);
        return $sql.$str." where {$column}={$id}";
    }
    public function setInsertSql($arr){
        $names = [];
        $values = [];
        foreach($arr as $k=>$v){
            $names[] = $k;
            $values[] = "'{$v}'";
        }
        $str_name = implode(',',$names);
        $str_values = implode(',',$values);
        $sql = "insert into `{$this->table}` ({$str_name}) values ({$str_values})";
        return $sql;
    }
}