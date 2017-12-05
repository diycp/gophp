<?php
namespace app\home\controller;

use gophp\controller;


class login extends controller {

    public function __call($name, $arguments)
    {

        $this->display('login');

    }

}