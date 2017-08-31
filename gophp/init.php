<?php

// 检测PHP版本
version_compare( PHP_VERSION, '5.5.0', '>=' ) or die( 'PHP版本需要大于5.5.0,当前版本' . PHP_VERSION);

// 引入composer自动加载文件
if(is_file($autoloadFile = ROOT_PATH . '/vendor/autoload.php')){

    require $autoloadFile;

}else{

    die('Please install composer first!');

}

// 默认关闭错误报告
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", "Off");

require __DIR__ . '/bootstrap/const.php';
require __DIR__ . '/function/function.php';

// 初始化核心框架
\gophp\app::run();
