<?php

namespace gophp;

use gophp\traits\driver;

class crypt
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('crypt'));

    }

}