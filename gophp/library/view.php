<?php

namespace gophp;

use gophp\traits\driver;

class view
{

    use driver;

    private function __construct()
    {

        return $this->handler(config::get('view'));

    }

}