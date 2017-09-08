<?php

/**
 * 友好的打印调试
 */
if (!function_exists('dump'))
{

    function dump()
    {

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
if(!function_exists('redirect'))
{

    function redirect($uri, $refresh = 0)
    {

        \gophp\response::redirect($uri, $refresh);

    }

}

/**
 * 获取输入参数
 */
if(!function_exists('input'))
{

    function input($key, $default = null)
    {

        return \gophp\request::getParam($key, $default);

    }

}

/**
 * 获取输入GET参数
 */
if(!function_exists('get'))
{

    function get($key, $default = null)
    {

        return \gophp\request::get($key, $default);

    }

}

/**
 * 获取输入POST参数
 */
if(!function_exists('post'))
{

    function post($key, $default = null)
    {

        return \gophp\request::post($key, $default);

    }

}

/**
 * 获取配置信息
 */
if(!function_exists('config'))
{

    function config($name, $key = null)
    {

        return \gophp\config::get($name, $key);

    }

}

/**
 * 优化的文件加载(只会加载一次)
 */
if(!function_exists('load'))
{

    function load($file, $data)
    {

        return \gophp\helper\file::load($file, $data);

    }

}

/**
 * 生成url
 */
if(!function_exists('url'))
{

    function url($uri = null, $arguments = [], $isAbsolute = false, $extension = null)
    {

        return \gophp\route::url($uri, $arguments, $isAbsolute, $extension);

    }

}

/**
 * 实例化db类
 */
if(!function_exists('db'))
{

    function db($table, $driver)
    {

        $db = \gophp\db::instance();

        return $db->driver($driver)->table($table);

    }

}

/**
 * cacehe类封装
 */
if(!function_exists('cache'))
{

    function cache($name, $value)
    {

        $cache = \gophp\cache::instance();

        if(is_null($value)){

            $cache->delete($name);

        }elseif(isset($value)){

            $cache->set($name, $value);

        }else{

            return $cache->get($name);

        }


    }

}

/**
 * session类封装
 */
if(!function_exists('session'))
{

    function session($name, $value)
    {

        $session = \gophp\session::instance();

        if(isset($value) && !is_null($value)){

            $session->set($name, $value);

        }elseif(isset($value) && is_null($value)){

            $session->delete($name);

        }else{

            return $session->get($name);

        }

    }

}

/**
 * cookie类封装
 */
if(!function_exists('cookie'))
{

    function cookie($name, $value)
    {

        $cookie = \gophp\cookie::instance();

        if(is_null($value)){

            $cookie->delete($name);

        }elseif(isset($value)){

            $cookie->set($name, $value);

        }else{

            return $cookie->get($name);

        }

    }

}

/**
 * 加密类封装
 */
if(!function_exists('encrypt'))
{

    function encrypt($str)
    {

        $crypt = \gophp\crypt::instance();

        return $crypt->encrypt($str);

    }

}

/**
 * 解密类封装
 */
if(!function_exists('decrypt'))
{

    function decrypt($str)
    {

        $crypt = \gophp\crypt::instance();

        return $crypt->decrypt($str);

    }

}