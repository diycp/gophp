<?php

namespace gophp\traits;

use gophp\exception;
use gophp\helper\str;
use gophp\reflect;

trait driver
{

    private $config  = [];
    private $handler = null;

    use instance;

    final private function handler(array $config)
    {

        $this->config = $config;

        $driver  = $this->config['driver'];

        $handler = self::class . '\\driver\\' . $driver;

        if(!class_exists($handler)){

            $className = reflect::getName(self::class);

            throw new exception('Driver not found', ucfirst($className) . ' driver ' . str::quote($driver) . ' not exist');

        }

        // 单例模式
        if (!($this->handler)) {

            $this->handler = new $handler($this->config);

        }

        return $this->handler;

    }

    // 设置驱动
    final protected function driver($driver)
    {

        isset($driver) and $this->config['driver'] = $driver;

        $this->handler = $this->handler($this->config);

        return $this->handler;

    }

    final public function __call($method, $arguments)
    {

        return call_user_func_array([$this->handler, $method], $arguments);

    }

    final public static function __callStatic($method, $arguments)
    {

        return call_user_func_array([self::instance(), $method], $arguments);

    }

    final public function __destruct()
    {

        $this->config  = null;
        $this->handler = null;

    }

}