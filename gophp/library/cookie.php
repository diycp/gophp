<?php

namespace gophp;

use gophp\traits\instance;

class cookie
{

    private $config;

    use instance;

    public function __construct()
    {

        $this->config = config::get('cookie');

    }

    private function key($key)
    {

        return $this->config['prefix'] . $key;

    }

    // 设置cookie
    public function set($key, $value, $expire = null, $path = null, $domain = null, $secure = null)
    {

        $expire = $expire ? $expire : $this->config['expire'];
        $path   = $path   ? $path   : $this->config['path'];
        $domain = $domain ? $domain : $this->config['domain'];
        $secure = $secure ? $secure : $this->config['secure'];

        // 如果是数组，对数组的每个元素加密
        if(is_array($value)){

            $value = array_map([$this, 'encrypt'], $value);

        }else{

            $value = $this->encrypt($value);

        }

        return setcookie($this->key($key), serialize($value), time()+$expire, $path, $domain, $secure);

    }

    // 获取cookie
    public function get($key)
    {

        if($this->has($key)){

            $value = unserialize($_COOKIE[$this->key($key)]);

            if(is_array($value)){

                return array_map([$this, 'decrypt'], $value);

            }else{

                return $this->decrypt($value);

            }

        }

        return '';

    }

    // 是否存在cookie
    public function has($key)
    {

        return isset($_COOKIE[$this->key($key)]);

    }

    // 删除指定cookie
    public function delete($key)
    {

        return $this->set($key, '', -1);

    }

    // 清除全部cookie
    public function clean()
    {

        foreach ($_COOKIE as $key => $val) {

            setcookie($key, '', -1, '/');

        }

    }

    // cookie加密
    private function encrypt($value)
    {

        return crypt::instance()->encrypt($value);

    }

    // cookie解密
    private function decrypt($value)
    {

        return crypt::instance()->decrypt($value);

    }

}