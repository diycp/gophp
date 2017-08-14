<?php

namespace gophp;

use gophp\traits\call;

class cookie
{

    private $config;

    use call;

    public function __construct()
    {

        $this->config = config::get('cookie');

    }

    private function key($key)
    {

        return $this->config['prefix'] . $key;

    }

    // 设置cookie
    protected function set($key, $value, $expire = null, $path = null, $domain = null, $secure = null)
    {

        $expire = $expire ? $expire : $this->config['expire'];
        $path   = $path   ? $path   : $this->config['path'];
        $domain = $domain ? $domain : $this->config['domain'];
        $secure = $secure ? $secure : $this->config['secure'];

        return setcookie($this->key($key), $this->encrypt($value), time()+$expire, $path, $domain, $secure);

    }

    // 获取cookie
    protected function get($key)
    {

        if($this->has($key)){

            return $this->decrypt($_COOKIE[$this->key($key)]);

        }

        return '';

    }

    // 是否存在cookie
    protected function has($key)
    {

        return isset($_COOKIE[$this->key($key)]);

    }

    // 删除指定cookie
    protected function delete($key)
    {

        return $this->set($key, '', -1);

    }

    // 清除全部cookie
    protected function clean()
    {

        foreach ($_COOKIE as $key => $val) {

            setcookie($key, '', -1, '/');

        }

    }

    // cookie加密
    private function encrypt($value)
    {

        return crypt::encrypt($value);

    }

    // cookie解密
    private function decrypt($value)
    {

        return crypt::decrypt($value);

    }

}