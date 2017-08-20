<?php

namespace gophp\session\driver;

use gophp\crypt;
use gophp\session\contract;

class file extends contract
{

    protected $config;

    public function __construct($config)
    {

        $this->config = $config;

    }

    public function set($key, $value, $expire = 0)
    {

        $expire = $expire ? $expire : $this->config['expire'];

        $expire and setcookie(session_name(), session_id(), time() + $expire, "/");

        // 如果是数组，对数组的每个元素加密
        if(is_array($value)){

            $value = array_map([$this, 'encrypt'], $value);

        }else{

            $value = $this->encrypt($value);

        }

        $_SESSION[$key]= serialize($value);

    }

    public function get($key)
    {

        if($this->has($key)){

            $value = unserialize($_SESSION[$key]);

            if(is_array($value)){

                return array_map([$this, 'decrypt'], $value);

            }else{

                return $this->decrypt($value);

            }

        }

    }

    public function has($key)
    {

        return isset($_SESSION[$key]);

    }

    public function delete($key)
    {

        unset($_SESSION[$key]);

    }

    public function clean()
    {

        $_SESSION = [];
        session_destroy();

    }

    private function encrypt($value)
    {

        return crypt::instance()->encrypt($value);

    }

    private function decrypt($value)
    {

        return crypt::instance()->decrypt($value);

    }

}