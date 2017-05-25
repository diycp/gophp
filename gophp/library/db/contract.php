<?php

namespace gophp\db;

abstract class contract
{

    protected $config;
    protected $db;
    protected $stmt;
    protected $tableName;
    protected $tablePrefix;
    protected $pk;
    protected $sql;

    abstract public function __construct($config);

    abstract public function connect();

    abstract public function table($table);

    abstract public function find($field);

    abstract public function findAll($field);

    abstract public function page($page,$listRows);

    abstract public function update(array $data);

    abstract public function inc($field, $offset = 1);

    abstract public function dec($field, $offset = 1);

    abstract public function add(array $data);

    abstract public function addAll();

    abstract public function delete($id);

    abstract public function count($field);

    abstract public function where($field , $expression, $value, $logic = 'AND');

    abstract public function order($order);

    abstract public function limit($offset,$rows = 0);

    abstract public function join($join);

    abstract public function on($on);

    abstract public function show($bool = false);

    public function __destruct()
    {
        $this->db = null;
    }

}