<?php

namespace gophp;

use gophp\traits\driver;

class db
{

    use instance;

    private $table;

    private function __construct($table, $prefix = null)
    {

        $this->table = $table;

    }

    public function test()
    {
        echo $this->table;
    }

}