<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2
 */

/**
 * 生成验证码
 * Class Captcha
 */
class Captcha
{
    public $code; //保存验证码
    private $count; //验证码length
    private $font;  //字体

    /**
     * 生成验证码
     * Captcha constructor.
     */
    public function __construct($count,$font){
        //初始化属性
        $this->font = $font;
        $this->count = $count;
        //组装数组
       $num = range(1,9);
       $up_code = range('A','Z');
       $low_code = range('a','z');
       $arr = array_merge($num,$up_code,$low_code);
       shuffle($arr); //打乱数组顺序
       $str = implode('',$arr); //转字符串
       $sub_str = substr($str,-$count); //截取指定长度的字符串
       $this->code =  $sub_str;
       //将生成的验证码放入session中
        @session_start();
        $_SESSION['Captcha'] = $this->code;
    }

    /**
     * @param $width  画布宽
     * @param $height  画布高
     * @param string $color 默认字体颜色 红色
     */
    public function setImage($width,$height){
          //生成画布
        $path = "./captcha_imgs/captcha_bg".mt_rand(1,5).".jpg";
        $image = imagecreatefromjpeg($path);
        //设置颜色
        $color_black = imagecolorallocate($image,0,0,0);
        $color_white = imagecolorallocate($image,255,255,255);
//        $bg_color =imagecolorallocate($image,$bg_color[0],$bg_color[1],$bg_color[2]);
        //填充画布
//        imagefill($image,0,0,$bg_color);
        //获取图片的宽高
        $size = getimagesize($path);
        list($width,$height) = $size;
        //写字
        $color = mt_rand(0,1)== 1? $color_black:$color_white;
        imagestring($image,$this->font,$width*1.2/3,$height/6,$this->code,$color);
        //加点

        for($i=0;$i<20;$i++){
            $point_x = mt_rand(0,$width-2);
            $point_y = mt_rand(0,$height-2);
            imagesetpixel($image,$point_x,$point_y,$color_black);
            imagesetpixel($image,$point_x,$point_y,$color_black);
        }
        //输出
        header('content-type:image/jpeg;charset=utf-8');
        imagejpeg($image);
        imagedestroy($image);
    }

}