<?php

namespace gophp;

use gophp\traits\instance;

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