<?php

namespace gophp;

use gophp\traits\instance;

class db
{

    use instance;

    private $prefix;
    private $table;

    private function __construct()
    {

        $this->config = config::get('db');


    }

    public function table($table, $prefix = null)
    {

        $this->prefix = isset($prefix) ? $prefix : $this->config['prefix'] . $table;
        $this->table  = $this->prefix . $table;

        echo $this->table;
    }

    public function driver($driver = null)
    {
        $this->driver = $driver;
    }

}