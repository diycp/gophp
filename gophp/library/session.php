<?php

namespace gophp;

use gophp\traits\driver;

class session
{

    use driver;

    private function __construct()
    {

        if(!$this->isActive()){

            session_start();

        }

        return $this->handler(config::get('session'));

    }

    // SESSION是否是激活状态
    protected function isActive()
    {

        return session_status() === PHP_SESSION_ACTIVE ? true : false;

    }

}