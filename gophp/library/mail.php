<?php

namespace gophp;

use gophp\traits\driver;

class mail
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('mail'));

    }

}