<?php

// 定义根目录
define('ROOT_PATH', __DIR__ . '/..');

// 定义根域名
define('ROOT_URL', dirname($_SERVER['REQUEST_URI']));

// 定义应用目录
define('APP_PATH', ROOT_PATH . '/application');

// 定义运行环境
define('APP_ENV', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'develop');

// 引入核心框架
require ROOT_PATH . '/gophp/init.php';
