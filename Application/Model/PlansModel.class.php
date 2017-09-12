<?php
class plansModel extends Model
{
    /**
     * 美发套餐
     */
    public function plans(){
        return $this->getAll();
    }
}