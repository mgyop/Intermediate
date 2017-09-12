<?php
/**
 * Created by Administrator.
 * Date: 2017/8/23
 */

/**
 * Class Page
 */
class Page{
     private $db;         //数据库对象
     private $total;      //总条数
     private $sql;        //查询语句
     //获取总数据
    /**
     * Page constructor.
     * @param $sql
     */
     public function __construct($sql)
     {
         //取得总的数据,保存
         $this->sql = $sql;
         $this->db= DB::getInstance($GLOBALS['config']['db']);
         $res = $this->db->fetchAll($sql);
         //dump($res);
         $this->total = count($res);
     }

    /**
     * 功能: 得到分页数据和分页字符串
     * 注意事项: URL 参数 &p=1 必须位于地址栏的末尾
     * @param $offset 每页显示的条数
     * @param $p  第几页
     * @param $len 页码长度
     * @return array
     */
    public function page(int $offset,int $p=1,int $len=6,$orderby='id desc'){
        //总页码
        $pages = ceil($this->total/$offset);
        //开始的记录数
        $start = ($p-1)*$offset;
        //当页数据
        $sql = $this->sql." order by {$orderby} limit {$start},{$offset}";
        $p_data = $this->db->fetchAll($sql);
        //获取当前页完整URL包括参数
        $url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        //如果参数p唯一,前面加 ? 参数指示符
        $res = strpos($url,'?');
        if($res === false){
            $url .= '?';
        }
        //如果参数 p 存在  去除 p 参数,已备下面赋值
        $res = strstr($url,'&p',true);
        if($res != false){
            $url = $res;
        }
        //显示选中的页码
        $on = "color:red";

        $str = "<div style='align:right;text-align: center;overflow:hidden '>";
        $str .= "<a style='float:left;position:relative;top:5px;'>共{$pages}页</a>";
        $str .= '<a style="float:left;position:relative;top:5px;width:50px;height:20px;"  href="'.$url.'&page=1">首页</a>';
        //限制页码长度
        if($pages>$len){
            $first_len = ceil($len/2);
        }else{
            $first_len = ceil($pages/2);
        }
        //限制跳转页码长度
        $first = $p-$first_len;
        if($first <= 0){
            $first = 1;
        }
        $last = $p+$len-$first_len;
        if($last >= $pages){
            $last = $pages;
        }
        if($first == 1){
            if($pages > $len){
                $last=$len+1;
            }else{
                $last=$pages;
            }
        }
        if($last == $pages){
            if($pages > $len){
                $first=$pages-$len;
            }else{
                $first=1;
            }
        }
        //拼装页码  字符串
        $str .= '<a style="position:relative;top:5px;float:left;width:50px;height:20px;" href="'.$url.'&page='.($p-1<1?1:$p-1).'">上一页</a>';
        for($i=$first;$i<=$last;++$i){
            $selected = $i == $p ? $on : '';
            $str .= "<a style='line-height:23px;font-size:14px;text-decoration:none;border:1px solid gray;display:block;float:left;margin:3px 5px;width:20px;height:20px;".$selected."'; href='{$url}&page={$i}'>{$i}</a>";
        }
        $str .= '<a style="position:relative;top:5px;float:left;width:50px;height:20px;" href="'.$url.'&page='.($p+1>$pages?$pages:$p+1).'">下一页</a>';
        $str .= '<a style="position:relative;top:5px;float:left;width:50px;height:20px;" href="'.$url.'&page='.$pages.'">尾页</a>';

        $str .= '<input id="go" style="float: left;margin-top: 5px;width: 35px;" type="text" name="go" > <a style="position:relative;top:5px;float:left;width:50px;height:20px;" href="'.$url.'&page=" onclick="this.href=this.href+document.getElementById(\'go\').value">go</a>';
        $str .= "</div><div style='clear: both;'></div>";
        return $res = [$str,$p_data];
     }
}