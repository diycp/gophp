<?php
//默认视图配置
return [

    'driver'             => 'smarty', //视图驱动
    '404_template'       => COMMON_VIEW . '/404', //404模板
    'error_template'     => COMMON_VIEW . '/error', //错误模板
    'success_template'   => COMMON_VIEW . '/success', //错误模板

    'smarty' => [
        'template_suffix' => 'html', //模板文件扩展名
        'left_delimiter'  => '{{', //左定界符
        'right_delimiter' => '}}', //右定界符
        'cache_enable'    => false, //是否缓存
        'cache_lifetime'  => 120, //缓存时间，单位秒
        'plugin_path'     => GOPHP_PLUG . '/smarty',
    ],

    'php' => [
        'template_suffix' => 'php', //模板文件后缀
    ],

];


