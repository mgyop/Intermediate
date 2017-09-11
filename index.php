<?php
header('Content-Type: text/html;charset=utf-8');
//开启session
session_start();
//网站代码自动跑起来
require  './Framework/Framework.class.php';
Framework::run();
