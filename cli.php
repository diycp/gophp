<?php
// 定义根目录
define('ROOT_PATH', __DIR__ . '/');

// 定义应用目录
define('APP_PATH', ROOT_PATH . '/application');

// 引入核心框架
require ROOT_PATH . '/gophp/init.php';

$argv = $_SERVER['argv'];

if($argv[0] !== 'cli.php'){

    $msg = $argv[0] . ' command not found';
    die( "\033[;32m $msg \x1B[0m\n" );
}

$module     = isset($argv[1]) ? $argv[1] : 'home';
$controller = isset($argv[2]) ? $argv[2] : 'index';
$action     = isset($argv[3]) ? $argv[3] : 'index';

die( "\033[;32m $module \x1B[0m\n" );

echo $module;exit;

// 拼装完整控制器类名
$fullController  = gophp\app::$namespace. '\\' . $module . '\\' . 'controller\\' . $controller;

// 拼装完整空控制器类名
$emptyController = gophp\app::$namespace. '\\' . $module . '\\' . 'controller\\call';






?>