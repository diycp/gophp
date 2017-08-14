<?php

namespace gophp;

use gophp\traits\instance;

class db
{

    use instance;

    private $table;

    private function __construct()
    {

        $this->config = config::get('db');


    }

    public function table($table, $prefix = null)
    {

        $this->table  = isset($prefix) ? $prefix : $this->config['prefix'] . $table;

        echo $this->table;
        echo 'lll';
    }

    public function driver($driver = null)
    {
        $this->driver = $driver;
    }

}