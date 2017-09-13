<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 */
class UploadModel extends Model
{
    private $max_size = 2*1024*1024;
    /**
     * 功能: 图片上传,
     * @param $files
     * @param string $dirName 文件名
     * @return string
     */
    public function img_upload($file,$filename='goods_logo/'){
        //上传失败返回false
        if($file['error'] != 0 ){
            //上传失败
            $this->error = "文件上传出错";
            return false;
        }
        if($file['error'] == 4){ // 不修改,返回 1
            return 1;
        }
        //处理文件
        if($file['size']>$this->max_size){
            $this->error = "图片最大不超过2M";
            return false;
        }
        //判断文件是否通过http 上传
        if(!is_uploaded_file($file['tmp_name'])){
            $this->error = "不是上传的文件";
            return false;
        }
        //得到文件后缀
        $ext = explode('/',$file['type'])[1];
        //得到原路径
        $old_path = $file['tmp_name'];
        //设计文件名
        $name = uniqid("logo_").'.'.$ext;
        $dirpath = UPLOADS_PATH.date("Ymd").'/'.$filename;
        $file = $dirpath.$name;
        //创建目录
        if(!file_exists($dirpath)){
            mkdir($dirpath,0777,true);
        }
        //移动文件
        $res = move_uploaded_file($old_path,$file);
        if(!$res){
            $this->error = "图片移动失败";
            return false;
        }
        //成功返回相对路径
        return str_replace(ROOT_PATH,'./',$file);
    }
    /**
     * 生成缩略图
     * @param $src_path
     * @return mixed
     */
    public function thumb($src_path,$thumb_width,$thumb_height){

        //>>1.打开原图资源
        $src_path = str_replace('./',ROOT_PATH,$src_path);
        $src_pathinfo = pathinfo($src_path);
        $image_func = "imagecreatefrom".$src_pathinfo['extension'];
        $src_image = $image_func($src_path);
        //获取原图片宽高
        $size = getimagesize($src_path);
        list($src_width,$src_height) = $size;

        //>>2. 打开新图片资源
        $thumb_image =  imagecreatetruecolor($thumb_width,$thumb_height);
        $white = imagecolorallocate($thumb_image,255,255,255);
        imagefill($thumb_image,0,0,$white);
        //>>3. copy图片
        //计算缩放比例
        $scal = max($src_width/$thumb_width,$src_height/$thumb_height);
        //得到原图缩放过后的宽高
        $width = $src_width/$scal;
        $height = $src_height/$scal;
        imagecopyresampled($thumb_image,$src_image,($thumb_width-$width)/2,($thumb_height-$height)/2,0,0,$width,$height,$src_width,$src_height);

        //>>4. 保存图片
        $thumb_path = $src_pathinfo['dirname'].'/'.$src_pathinfo['filename']."_{$thumb_width}x{$thumb_height}.".$src_pathinfo['extension'];
        $image_func = "image".$src_pathinfo['extension'];
        $image_func($thumb_image,$thumb_path);
        //>>5. 关闭图片资源
        imagedestroy($thumb_image);
        imagedestroy($src_image);
        //>>6. 返回缩略图路径
        return str_replace(ROOT_PATH,'./',$thumb_path);
    }
}