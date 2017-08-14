<?php

namespace gophp;

use gophp\traits\driver;

class captcha
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('captcha'));

    }

}