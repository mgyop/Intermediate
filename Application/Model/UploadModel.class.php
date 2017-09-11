<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 */
class UploadModel extends Model
{
    /**
     * 功能: 图片上传,
     * @param $files
     * @param string $dirName 文件名
     * @return string
     */
    public function img_upload($files,$dirName='goods_logo/'){

        if($files['error'] === 0){
            //获取文件类型
            $options = explode('/',$files['type']);
            if( $options[0] != 'image'){
                die("文件格式不正确");
            }
            $fileName = uniqid('logo_').'.'.$options[1];
            $dir= UPLOADS_PATH.$dirName.date('Y-m-d',time()).'/';
            if(!is_dir($dir)){
                mkdir($dir,0777,true);
            }
            move_uploaded_file($files['tmp_name'],$dir.$fileName);
            return $dir.$fileName;
        }else{
            $this->error = "文件上传错误";
            return false;
        }

    }
}