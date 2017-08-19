<?php

namespace gophp;

use gophp\traits\instance;

class demo
{

    use instance;

    private $config;
    private $driver;
    private $handler;

    private function __construct()
    {

        $this->config = config::get('db');

        $this->driver = $this->config['driver'];

    }

    public function driver($driver)
    {

        isset($driver) && $this->driver = $driver;

        return $this;

    }

    public function connect()
    {

        $driver = '\\gophp\\db\\driver\\' . $this->driver;

        $this->handler = new $driver($this->config);

        return $this->handler->connect();

    }

    public function table($table, $prefix)
    {

        $this->connect();

        $this->handler->table($table, $prefix);

        return $this;
    }

    public function where()
    {
        return $this;
    }

    public function limit()
    {
        return $this;
    }


}