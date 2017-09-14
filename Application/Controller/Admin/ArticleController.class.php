<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/13
 */
class ArticleController extends Controller
{
    public function show(){
        $article_id = $_GET['article_id'];
        //根据id去数据
        $row = D('article')->getOne($article_id);
        $this->assign('row',$row);
        $this->display('show');
    }
    /**
     * 展示档期活动
     */
    public function index(){

        //创建模型
        $ArticleModel = D('article');
        //获取所有的活动
        $page = $_GET['page'] ?? 1;
        //获取条件
        $get = $_GET;
        $where = $ArticleModel->serach($get);
        //加入条件到分页中
        $rows= getPage('article',3,$page,5,'start desc',$where);
        //改装下rows数据
        foreach($rows[1] as $k=>&$v){
            if($v['end'] < $v['start']){
                $v['status'] = '活动结束';
            }elseif(time() < $v['start']){
                $v['status'] = '活动未开始';
            }else {
                $v['status'] = '活动已开始了';
            }
        }
        $serach=[];
        foreach ($get as $k=>&$v){
            if(!empty($v)){
                $serach[$k] = $v;
            }
        }
        //分配数据
        $this->assign('serach',$serach);
        $this->assign('rows',$rows);
        //liebiao
        $this->display('index');
    }
    /**
     * 添加活动
     */
   public function add(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $post = $_POST;
           $ArticleModel = D('Article');
           //失败返回false
           $result = $ArticleModel->add($post);
           if($result == false){
               $this->error("?p=Admin&c=Article&a=add",$ArticleModel->getError(),2);
           }
           $this->success("?p=Admin&c=Article&a=index");
       }
       //展示添加表单
       $this->display('add');
   }

    /**
     * 修改
     */
   public function edit(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $post = $_POST;
           $ArticleModel = D('Article');
           //失败返回false
           $result = $ArticleModel->update($post);
           if($result == false){
               $this->error("?p=Admin&c=Article&a=edit&article_id={$post['article_id']}",$ArticleModel->getError(),2);
           }
           $this->success("?p=Admin&c=Article&a=index");
       }
       $article_id = $_GET['article_id'];
       //展示添加表单,回显
       $row = D('article')->getOne($article_id);
       //分配数据
       $this->assign('row',$row);
       $this->display('edit');
   }

    /**
     * 删除活动
     */
   public function delete(){
       $article_id = $_GET['article_id'];
       D('article')->delOne($article_id);
       $this->success("?p=Admin&c=Article&a=index");
   }
   public function end(){
       $article_id = $_GET['article_id'];
       $ArticleModel = D('article');
       $ArticleModel->end($article_id);
       $this->success("?p=Admin&c=Article&a=index");
   }
}