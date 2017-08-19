<?php

namespace gophp;

use gophp\traits\instance;

class view
{

    public $config;
    public $driver;
    public $handler;

    use instance;

    private function __construct()
    {

        $this->config = config::get('view');

        $this->driver = $this->config['driver'];

    }

    public function driver($driver)
    {

        isset($driver) && $this->driver = $driver;

        return $this;

    }

    private function handler()
    {

        $driver = self::class . '\\driver\\' . $this->driver;

        if(!class_exists($driver)){

            $className = reflect::getName(self::class);

            throw new exception( ucfirst($className) . ' driver ' . str::quote($this->driver) . ' not exist');

        }

        // 单例模式
        if(!$this->handler){

            $this->handler = new $driver($this->config);

        }

        return $this->handler;

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

        $this->handler = $this->handler();

        $method = __FUNCTION__;

        return $this->handler->$method($viewName);
    }

}