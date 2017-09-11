<?php
header('Content-Type: text/html;charset=utf-8');
//开启session
session_start();

$_ENV['name'] = "undo";
require  './Framework/Framework.class.php';
Framework::run();
