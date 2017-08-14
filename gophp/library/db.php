<?php

namespace gophp;

use gophp\traits\driver;

class db
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('db'));

    }

}