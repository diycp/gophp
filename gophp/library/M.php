<?php

namespace gophp;

use gophp\traits\driver;

class db
{

    use driver;

    private function __construct($table, $prefix = null)
    {

        echo $table;

    }

    public function demo()
    {

    }
    
}