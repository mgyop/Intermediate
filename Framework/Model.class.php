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
        $tableName = strtolower(strstr($className,'M',true)); //获取表名
        $this->table = $tableName; //保存表名
        return $this->table;
    }

    /**
     * 根据id删除一条记录
     * @param int $id
     * @return int
     */
    public function delOne(int $id){
        $this->db->query("delete from {$this->table} where id={$id}");
        return $id;
    }

}