<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 */

/**
 * 加减法验证码类
 * Class CaptchaYunSuan
 */
class CaptchaYunSuan
{
    private $fu=''; //保存符号
    private $num = []; //保存操作数
    private $result;   //保存结果
    private $str='';   //保存运算字符串

    public function __construct($width=110,$height=35,$font=5)
    {
        $this->yunSuanFu();
        $this->getNumber();
        $this->yunSuan();
        $_SESSION['login_captcha'] = md5($this->result."it_source");
        $this->echoImg($width,$height,$font);
    }

    /**
     * 随机运算符
     */
   private function yunSuanFu(){
       $fu = ['+','-','*'];
       $k = mt_rand(0,2);
       $this->fu = $fu[$k];
   }

    /**
     * 得到随机操作数
     * @param int $count
     */
    private function getNumber($count=2){
       for($i=0;$i<$count;++$i){
           $this->num[$i] = mt_rand(0,20);
       }
   }

    /**
     * 计算结果
     */
    private function yunSuan(){
        switch($this->fu){
            case '*':
               $this->result = $this->num[0] * $this->num[1];
               $this->str = $this->num[0]." X ".$this->num[1]." =?";
                break;
            case '+':
               $this->result = $this->num[0] + $this->num[1];
               $this->str = $this->num[0]." + ".$this->num[1]." =?";
                break;
            case '-':
                if($this->num[0] > $this->num[1]){
                    $this->result = $this->num[0] - $this->num[1];
                    $this->str = $this->num[0]." - ".$this->num[1]." =?";
                }else{
                    $this->result = $this->num[1] - $this->num[0];
                    $this->str = $this->num[1]." - ".$this->num[0]." =?";
                }
                break;
        }
    }
    private function echoImg($width,$height){
        //创建画布
        $image = imagecreatetruecolor($width,$height);
        //背景
        $bg_color = imagecolorallocate($image,255, 110, 41);
        //字颜色
        $font_color = imagecolorallocate($image,0,0,155);
        //填充背景
        imagefill($image,0,0,$bg_color);
        //画点
        for($j=1;$j<20;++$j){
            $point_color = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
            imagesetpixel($image,mt_rand(1,$width),mt_rand(1,$height),$point_color);
        }
        //划线
         for($k=1;$k<5;++$k){
             $w   = imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
             $r = imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
             $style = array($r,$w);
             //划线的风格
             imagesetstyle($image, $style);
             imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width),  mt_rand(0,$height), IMG_COLOR_STYLED);
         }
        //写字
        imagestring($image,5,$width/9,$height/4,$this->str,$font_color);
        header('content-type:image/jpeg;charset=utf-8');
        //输出图片
        imagejpeg($image);
        //销毁
        imagedestroy($image);
    }
}
