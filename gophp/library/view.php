<?php

namespace gophp;

use gophp\traits\driver;

class view
{

    public $config;
    public $driver;
    public $handler;

    use driver;

    private function __construct()
    {

        $this->config = config::get('view');

        $this->driver = $this->config['driver'];

    }

    public function exists($viewFile)
    {

        $method = __FUNCTION__;

        return $this->handler()->$method($viewFile);

    }

    public function assign($name, $value)
    {

        $method = __FUNCTION__;

        return $this->handler()->$method($name, $value);

    }

    public function display($viewName)
    {

        $method = __FUNCTION__;

        return $this->handler()->$method($viewName);
    }

}