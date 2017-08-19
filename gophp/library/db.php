<?php

namespace gophp;

use gophp\db\contract;
use gophp\helper\str;
use gophp\traits\instance;

class db extends contract
{

    use instance;

    public $config;
    public $driver;
    public $handler;

    private function __construct()
    {

        $this->config = config::get('db');

        $this->driver = $this->config['driver'];

    }

    public function connect()
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

        return $this->handler->connect();

    }

    public function driver($driver)
    {

        isset($driver) && $this->driver = $driver;

        return $this;

    }

    public function table($table, $prefix)
    {

        $this->connect();

        $method = __FUNCTION__;

        $this->handler->$method($table, $prefix);

        return $this;
    }

    public function where($field , $expression, $value, $logic = 'AND')
    {

    }

    public function order($order)
    {
        $method = __FUNCTION__;

        return $this->handler->$method($order);
    }

    public function limit($offset, $rows = 0)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($offset, $rows);

    }

    public function join($join)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($join);

    }

    public function on($on)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($on);

    }

    public function show($bool = false)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($bool);

    }

    public function find($field)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($field);

    }

    public function findAll($field)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($field);

    }

    public function page(page $page, $pageNo)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($page, $pageNo);

    }

    public function update(array $data)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($data);
    }

    public function inc($field, $offset = 1)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($field, $offset);
    }

    public function dec($field, $offset = 1)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($field, $offset);

    }

    public function add(array $data)
    {

        $method = __FUNCTION__;

        return $this->handler->$method($data);

    }


    public function addAll()
    {

    }

    public function delete($id)
    {

    }

    public function count($field)
    {

    }

    public function max($field)
    {

    }

    public function min($field)
    {

    }

    public function avg($field)
    {

    }

    public function sum($field)
    {

    }


}