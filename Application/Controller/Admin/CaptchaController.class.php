<?php
class CaptchaController extends Controller
{
    public function yan(){
        //设置随机数
        $x=mt_rand(1,20);
        $y=mt_rand(1,20);
        $d=mt_rand(0,1)?'+':'x';
        $mun="$x$d$y=?";

        //将生成的随机数放入session中
        session_start();
        if ($d==='x'){
            $_SESSION['muns']=($x*$y);
        }else{
            $_SESSION['muns']=($x+$y);
        }
        $width=145;
        $height=20;
        $image_path = PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";   // 生成随机数
        $image=imagecreatefromjpeg($image_path);

        $black=imagecolorallocate($image,0,0,0);
        $white=imagecolorallocate($image,255,255,255);

        //写字
        imagestring($image,5,$width*1.2/3,$height/8,$mun,mt_rand(0,1)?$black:$white);

        ob_clean();
        //输出图片到浏览器
        header("Content-Type:image/jpeg;");
        imagejpeg($image);
        //销毁图片
        imagedestroy($image);
    }
}
