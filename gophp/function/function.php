<?php

/**
 * 友好的打印调试
 */
if (!function_exists('dump')){

    function dump() {

        if(func_num_args() < 1){

            var_dump(null);

        }

        //获取参数列表
        $args_list = func_get_args();

        echo '<pre>';

        foreach ($args_list as $arg) {

            $type = gettype($arg);

            if(!$arg){

                var_dump($arg);

            }elseif($type == 'array'){

                print_r($arg);

            }elseif(in_array($type, ['object', 'resource', 'boolean', 'NULL', 'unknown type'])){

                var_dump($arg);

            }else{

                echo $arg . '<br>';

            }

        }

        echo "</pre>";

    }

}

/**
 * 获取输入参数
 */
if(!function_exists('input')){

    function input($key, $default){

        return \gophp\request::getParam($key, $default);

    }

}

/**
 * 获取配置信息
 */
if(!function_exists('config')){

    function config($name, $key){

        return \gophp\config::get($name, $key);

    }

}

/**
 * 优化的文件加载(只会加载一次)
 */
if(!function_exists('load')){

    function load($file, $data){

        return \gophp\helper\file::load($file, $data);

    }

}

/**
 * 生成url
 */
if(!function_exists('url')){

    function url($uri = null, $arguments = [], $isAbsolute = false, $extension = null){

        return \gophp\route::url($uri, $arguments, $isAbsolute, $extension);

    }

}


