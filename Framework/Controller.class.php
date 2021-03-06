<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/29
 * Time: 14:46
 */
class Controller
{

    //默认member头像图片路径
    protected $path;
    protected $thumb_path;
    private $datas = []; //存放数据容器. 该容器中的数据需要在页面中使用到.
    public $startTime;
    public $lastTime;
    public $memory;
    public function __construct()
    {
        //判断是否登录
        if(isset($_SESSION['user_userinfo'])){
            $integrate = D('user')->getIntegrate($_SESSION['user_userinfo']['user_id']);
            $_SESSION['user_userinfo']['integrate'] = $integrate;
        }
        $this->startTime=explode(' ', microtime());
        //初始化默认路径
        $this->thumb_path = str_replace(ROOT_PATH,'./',PUBLIC_PATH."commen/logo_59b7bd174d368_46x46.jpeg");
        $this->path = str_replace(ROOT_PATH,'./',PUBLIC_PATH."commen/logo_59b7bd174d368.jpeg");
    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        //当前时间(微秒 秒)
        $this->lastTime=explode(' ', microtime());
        $time = $this->lastTime[0]/100;
        //内存峰值
        $memory = $this->memory =memory_get_peak_usage()/(1024*1024);
        //排除特例
        if(ACTION_NAME == 'menu' || ACTION_NAME == 'login' || ACTION_NAME == 'register'){
             die;
        }else{
            require COMMEN_PATH."footer.html";
        }
    }

    /**
     * 加载当前控制器对应的视图文件夹下的模板
     * @param $template 模板的名字
     */
    public function display($template){
        extract($this->datas); //将datas中的数据解析成变量.  变量名就是键的名字
        require CURRENT_VIEW_PATH.$template.'.html';
    }

    /**
     * 将数据放到$data中
     * @param $name
     * @param $value
     */
    public function assign($name,$value=''){
        if(is_array($name)){
            //如果name是数组,将$name的数据直接合并到$datas中
            $this->datas = array_merge($this->datas,$name);  //$name = array('key1'=>value1,'key2'=>value2);
        }else{
            $this->datas[$name] = $value;
        }
    }



    /**
     * 跳转
     * @param $url  跳转的url
     * @param $msg   提示的信息
     * @param $time  等待时间,秒
     */
    protected static function redirect($url,$msg='',$time=0){
        if(!headers_sent()){  //headers_sent检测header是否发送给浏览器
            //header没有发送,使用header跳转
            if($time==0){ //立即跳转
                header("Location: $url");
            }else{  //延迟跳转
                echo '<h2>'.$msg.'</h2>';  //跳转之前输出提示信息
                header("Refresh: $time;url=$url");
            }
        }else{
            if($time!=0){   //延时跳转
                echo '<h1>'.$msg.'</h1>';  //提示信息
                $time = $time * 1000;
            }
            //使用js跳转
            echo <<<JS
            <script type='text/javascript'>
                window.setTimeout(function(){
                  location.href = '{$url}';
                },{$time});
            </script>
JS;
        }
    }

    /**
     * 错误跳转中页面
     * @param $url
     * @param string $msg
     * @param int $time
     */
    protected  function error($url,$msg='',$time=0){
        if(!headers_sent()){  //headers_sent检测header是否发送给浏览器
            //header没有发送,使用header跳转
            if($time==0){ //立即跳转
                header("Location: $url");
            }else{  //延迟跳转
                if(file_exists(COMMEN_PATH."error.html")){
                    require COMMEN_PATH."error.html"; //跳转之前输出提示信息
                }else{
                    echo '<h2>'.$msg.'</h2>';  //跳转之前输出提示信息
                }
                header("Refresh: $time;url=$url");
            }
        }else{
            if($time!=0){   //延时跳转
                echo '<h1>'.$msg.'</h1>';  //提示信息
                $time = $time * 1000;
            }
            //使用js跳转
            echo <<<JS
            <script type='text/javascript'>
                window.setTimeout(function(){
                  location.href = '{$url}';
                },{$time});
            </script>
JS;
        }
        exit;  //跳转之后没有必要再执行其他的代码.
    }

    /**
     * 成功跳转中页面
     * @param $url
     * @param string $msg
     * @param int $time
     */
    protected  function success($url,$msg='',$time=0){
        if(!headers_sent()){  //headers_sent检测header是否发送给浏览器
            //header没有发送,使用header跳转
            if($time==0){ //立即跳转
                header("Location: $url");
            }else{  //延迟跳转
                if(file_exists(COMMEN_PATH."success.html")){
                    require COMMEN_PATH."success.html"; //跳转之前输出提示信息
                }else{
                    echo '<h2>'.$msg.'</h2>';  //跳转之前输出提示信息
                }
                header("Refresh: $time;url=$url");
            }
        }else{
            if($time!=0){   //延时跳转
                echo '<h1>'.$msg.'</h1>';  //提示信息
                $time = $time * 1000;
            }
            //使用js跳转
            echo <<<JS
            <script type='text/javascript'>
                window.setTimeout(function(){
                  location.href = '{$url}';
                },{$time});
            </script>
JS;
        }
        exit;  //跳转之后没有必要再执行其他的代码.
    }

}