<?php

namespace gophp;

use gophp\traits\driver;

class cache
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('cache'));

    }

}