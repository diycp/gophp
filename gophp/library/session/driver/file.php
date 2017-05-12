<?php

namespace gophp\session\driver;

use gophp\crypt;
use gophp\session\contract;

class file extends contract
{

    public function set($key, $value, $expire = 0)
    {

        $expire = $expire ? $expire : $this->config['prefix'];

        $expire and setcookie(session_name(), session_id(), time() + $expire, "/");

        $_SESSION[$key]= $this->encrypt($value);

    }

    public function get($key)
    {

        if($this->has($key)){

            return $this->decrypt($_SESSION[$key]);

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

        return crypt::encrypt($value);

    }

    private function decrypt($value)
    {

        return crypt::decrypt($value);

    }

}