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

    public function set($name, $value, $expire = 0)
    {

        $expire = $expire ? $expire : $this->config['expire'];

        $expire and setcookie(session_name(), session_id(), time() + $expire, "/");

        // 如果是数组，对数组的每个元素加密
        if(is_array($value)){

            $value = array_map([$this, 'encrypt'], $value);

        }else{

            $value = $this->encrypt($value);

        }

        $_SESSION[$name]= serialize($value);

    }

    public function get($name)
    {

        if(strpos($name, '.') > 0){

            $key = explode('.', $name)[0];

        }else{

            $key = $name;
        }

        if($this->has($key)){

            $value = unserialize($_SESSION[$key]);

            if(is_array($value)){

                $value  = array_map([$this, 'decrypt'], $value);

                if($key = explode('.', $name)[1]){

                    return $value[$key];

                }

                return $value;

            }else{

                return $this->decrypt($value);

            }

        }

        return null;

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