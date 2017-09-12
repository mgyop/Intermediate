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
        if($file['error'] == 0 ){
            if($file['error'] == 4){ // 不修改,返回 1
                return 1;
            }else{ //处理文件
                if($file['size']>$this->max_size){
                    $this->error = "图片最大不超过2M";
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
        }else{
            //上传失败
            $this->error = "文件上传出错";
            return false;
        }
    }
}