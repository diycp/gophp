<?php

// 检测PHP版本
version_compare( PHP_VERSION, '5.5.0', '>=' ) or die( 'PHP版本需要大于5.5.0,当前版本' . PHP_VERSION);

// 引入composer自动加载文件
if(is_file($autoload_file = ROOT_PATH . '/vendor/autoload.php')){

    require $autoload_file;

}else{

    die('Please run composer install first!');

}

// 默认关闭错误报告
ini_set("display_errors", "Off");

require __DIR__ . '/bootstrap/const.php';
require __DIR__ . '/function/function.php';

// DEBUG模式开启错误报告
if(APP_DEBUG){

    ini_set("display_errors", "On");
    error_reporting(E_ALL | E_STRICT);

}

// 初始化核心框架
\gophp\app::run();
