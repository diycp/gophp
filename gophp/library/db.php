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

        $this->table  = isset($prefix) ? $prefix : $this->config['prefix'] . $table;

    }

    public function table($table, $prefix = null)
    {
        echo $this->table;
    }

    public function driver($driver = null)
    {
        $this->driver = $driver;
    }

}