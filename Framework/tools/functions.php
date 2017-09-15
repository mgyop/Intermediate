<?php
/**
 * Created by Administrator.
 * Date: 2017/8/29
 */
/**
 * 获取客户端IP地址
 * @return array|false|string
 */
function getClientIP()
{
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    elseif(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    elseif(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "0";
    return $ip;
}
/**
 * 功能: 图片上传,
 * @param $files
 * @param string $dirName 文件名
 * @return string
 */
function img_upload($files,$dirName='logo/'){

    if($files['error'] === 0){
        //获取文件类型
        $options = explode('/',$files['type']);
        if( $options[0] != 'image'){
            die("文件格式不正确");
        }
        $fileName = uniqid('logo_').'.'.$options[1];
        $dir= UPLOADS_PATH.$dirName.date('Y-m-d-H',time()).'/';
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        move_uploaded_file($files['tmp_name'],$dir.$fileName);
        return $dir.$fileName;
    }else{
        die("文件上传不完整");
    }

}
/**
 * 功能: 实现分页
 * @param $tableName  表名
 * @param $offset 偏移量
 * @param $p  页码
 * @param $len  页码长度
 * @return array [$str,$data]
 */
function getPage($tableName,$offset,$p,$len,$orderby,$where){
    $sql = "select * from ".$tableName.$where;
    $page = New Page($sql);
    return $page->page($offset,$p,$len,$orderby);
}

/**
 * 功能:创建模型
 * @param $tableName
 * @return mixed
 */
function D($tableName){
    //首字母
    $tableName = ucfirst(strtolower($tableName));
    $className = $tableName.'Model';
    return new $className();
}


/**
 * 打印
 * @param $data
 */
function dump($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

/**
 * 功能: 输出字符串
 * @param $data
 */

function p($data){
    echo "<hr />";
    echo "<pre>";
    echo $data;
}