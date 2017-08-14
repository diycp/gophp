<?php

namespace gophp;

use gophp\traits\instance;

class db
{

    use instance;

    private $prefix;
    private $table;
    private $driver;

    private function __construct()
    {

        $this->config = config::get('db');

    }

    public function table($table, $prefix = null)
    {

        $this->prefix = isset($prefix) ? $prefix : $this->config['prefix'];
        $this->table  = $this->prefix . $table;

        return $this;
    }

    public function driver($driver = null)
    {

        $this->driver = isset($driver) ? $driver : $this->config['driver'];

        return $this;
    }

}