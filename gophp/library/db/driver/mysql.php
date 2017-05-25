<?php

namespace gophp\db\driver;

use gophp\config;
use gophp\db\contract;
use gophp\exception;
use gophp\page;
use gophp\request;
use gophp\schema;
use PDO;

class mysql extends contract
{

    private $bind   = [];
    private $option = ['where' => '', 'set' => '', 'join' => '', 'on' => '', 'order' => '', 'limit' => ''];
    private $chain  = ['show' => '', 'lock' => '','count' => '', 'logic' => ''];

    /**
     * mysql 构造方法
     * @param $config
     */
    public function __construct($config)
    {

        $this->config = $config['mysql'];

        $this->db     = $this->connect();

    }

    /**
     * 连接数据库
     * @return mixed|PDO
     * @throws exception
     */
    public function connect()
    {

        try {

            $this->db = new PDO($this->dsn(), $this->config['user'], $this->config['password']);

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); //使用缓冲查询，仅mysql有效
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true); //启用预处理语句的模拟
            $this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL); //强制列名小写
            $this->db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL); //指定数据库返回的NULL值在php中对应的数值
            $this->db->setAttribute(PDO::ATTR_AUTOCOMMIT, 1); //开启自动提交

            //设置字符集
            $this->db->exec('SET NAMES ' . $this->config['charset']);

            return $this->db;

        } catch(\PDOException $e) {

            throw new exception("mysql connect Error:" . $e->getMessage());

        }

    }

    /**
     * 选择表
     * @param $table
     * @param string $prefix
     * @return $this
     */
    public function table($table, $prefix = '')
    {

        $this->tablePrefix = isset($prefix) ? $prefix : $this->config['prefix'];

        $this->tableName   = '`' . $prefix . $table . '`';

        return $this;

    }

    /**
     * 查询单条数据
     * @param string $field
     * @return array
     */
    public function find($field = '*')
    {

        $this->pk  = schema::getPK($this->tableName);

        $field = $field ? $field : '*';

        $this->option['limit'] = 1;

        $this->option['order'] = $this->pk.' DESC'; //主键ID降序

        if(is_numeric($field)){

            $this->where($this->pk, '=', $field);

            $this->sql = "SELECT * FROM " . $this->tableName . $this->option();

        }else{

            $this->sql = "SELECT $field FROM " . $this->tableName . $this->option();

        }

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        return $this->stmt->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * 查询单个字段值
     * @param $field
     * @return string
     */
    public function value($field)
    {

        if(!$field){

            return '';
        }

        $result = $this->find($field);

        return $result[$field];

    }

    /**
     * 查询多条数据
     * @param string $field
     * @return array
     */
    public function findAll($field = '*')
    {

        $field = $field ? $field : '*';

        $this->sql  = "SELECT $field FROM " . $this->tableName . $this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * 更新数据
     * @param array $data
     * @return int|bool
     */
    public function update(array $data)
    {

        unset($this->option['order']);
        unset($this->option['limit']);

        $this->option['set'] = $this->set($data);

        $this->sql  = "UPDATE " . $this->tableName . $this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        // 返回影响行数
        return $this->stmt->rowCount();

    }

    /**
     * 自增
     * @param $field
     * @param int $offset
     * @return int
     */
    public function inc($field, $offset = 1)
    {

        unset($this->option['order']);
        unset($this->option['limit']);

        $this->option['set'] = $field . '=' . $field .'+'. $offset;

        $this->sql  = "UPDATE " . $this->tableName . $this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        // 返回影响行数
        return $this->stmt->rowCount();

    }

    /**
     * 自减
     * @param $field
     * @param int $offset
     * @return int
     */
    public function dec($field, $offset = 1)
    {

        unset($this->option['order']);
        unset($this->option['limit']);

        $this->option['set'] = $field . '=' . $field .'-'. $offset;

        $this->sql  = "UPDATE " . $this->tableName . $this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        // 返回影响行数
        return $this->stmt->rowCount();

    }

    /**
     * 添加单条数据
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {

        $this->option = [];

        $this->option['set'] = $this->set($data);

        $this->sql  = "INSERT INTO " . $this->tableName .$this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        // 返回自增ID
        return $this->db->lastInsertId();

    }

    /**
     * 添加多条数据
     * @param array $data
     * @return int
     */
    public function addAll()
    {

        $args_value = '';

        //获取参数数量
        $args_count = func_num_args();

        if($args_count <= 1){

            return 0;

        }

        //获取参数列表
        $args_list  = func_get_args();

        $args_field = implode(',', $args_list[0]);

        $args_field = '(' . trim($args_field, ',') . ')';

        for ($i = 0; $i < $args_count; $i++) {

            if(!is_array($args_list[$i])){

                continue;

            }

            $args_value .= '(';

            foreach($args_list[$i] as $k1 =>$v1){

                if(is_string($v1)){

                    $args_value .= "'" . $v1 . "',";

                }else{

                    $args_value .= $v1 . ",";

                }

            }

            $args_value = trim($args_value, ',');

            $args_value .= '),';

        }

        $args_value = trim($args_value, ',');

        $this->sql  = "INSERT INTO $this->tableName {$args_field} VALUES {$args_value}";

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        // 返回影响行数
        return $this->stmt->rowCount();

    }

    /**
     * 删除数据
     * @return int|\PDOStatement
     */
    public function delete($id)
    {

        $pk = schema::getPK($this->tableName);

        if(is_array($id) && $id){

            $this->where($pk, 'in', $id);

        }elseif($id){

            $this->where($pk, '=', $id);

        }else{

            return false;

        }

        unset($this->option['order']);
        unset($this->option['limit']);

        $this->sql = "DELETE FROM $this->tableName" . $this->option();

        if($this->chain['show']){

            return $this->sql;

        }

        if(!$this->option['where']){

            // 防止误删除
            return false;

        }

        $this->stmt = $this->execute($this->bind);

        // 返回影响行数
        return $this->stmt->rowCount();

    }

    /**
     * 查询数量
     * @param $field
     * @return \PDOStatement|string
     */
    public function count($field)
    {
        $field = $field ? $field : '*';

        $this->sql = "SELECT COUNT(" . $field . ") FROM " . $this->tableName . $this->option();

        $this->stmt = $this->execute($this->bind);

        if($this->chain['show']){

            return $this->stmt;

        }

        return $this->stmt->fetchColumn();
    }

    /**
     * 操作条件
     * @param $field
     * @param $condition
     * @param $value
     * @param string $logic
     * @return $this
     */
    public function where($field , $condition, $value, $logic = 'AND')
    {

        $this->bind = $this->bind([$field => $value]);

        if(strtoupper($value) == 'NULL'){

            $value = strtoupper($value);

        }elseif(strtoupper($condition) == 'IN' || strtoupper($condition) == 'NOT IN'){

            is_array($value) and $value = '('. implode(',', (array)$value). ')';

        }elseif(strtoupper($condition) == 'BETWEEN' || strtoupper($condition) == 'NOT BETWEEN'){

            is_array($value) and $value = $value[0] . ' AND ' . $value[1];

        }elseif(!$this->chain['show']){

            $value = ':' . $field;

        }

        $this->chain['logic']  = $logic ? strtoupper($logic) : 'AND';

        $this->option['where'] .= '`' . $field . '` ' . strtoupper($condition) . ' ' . $value . ' ' . $this->chain['logic'] . ' ';

        return $this;

    }

    /**
     * 排序
     * @param $order
     * @return $this
     */
    public function order($order)
    {

        $this->option['order'] = $order;

        return $this;
    }

    /**
     * @desc 返回条数
     * @param $offset
     * @param int $rows
     * @return $this
     */
    public function limit($offset,$rows = 0)
    {

        $offset = intval($offset);
        $rows   = intval($rows);

        if (!$rows){

            $this->option["limit"] = "0," . $offset;

        }else{

            $this->option["limit"] = $offset . ',' . $rows;

        }

        return $this;
    }

    /**
     * @desc 分页查询
     * @param $pageRows 每页显示条数
     * @param $page 当前页码
     * @return $this
     */
    public function page($pageRows, $pageNo = null)
    {

        $pageParam = config::get('http', 'page_param');

        $pageNo    = $pageNo ? $pageNo : request::getParam($pageParam, 1);

        $firstRow  = $pageRows * ($pageNo - 1);

        $this->option["limit"] = $firstRow . ',' . $pageRows;

        return $this;

    }

    /**
     * @desc 联合查询
     * @param $table
     * @param string $type
     * @return $this
     */
    public function join($table, $type = 'inner')
    {

        $this->option[strtolower($type).' join'] = '`' . $table . '`';

        return $this;

    }

    public function on($on)
    {

        $this->option['on'] = $on;

        return $this;

    }

    /**
     * 是否只展示sql语句不执行
     * @param bool $show
     * @return $this
     */
    public function show($show = false)
    {

        $this->chain['show'] = $show;
        return $this;

    }

    /**
     * 获取DSN
     * @return string
     * @throws exception
     */
    private function dsn()
    {

        $host = $this->config['host'];
        $port = $this->config['port'];
        $name = $this->config['name'];

        if(!$host || !$port || !$name){

            throw new exception("DSN Error", "Required DSN parameter is missing");

        }

        return "mysql:host={$host};port={$port};dbname={$name}";

    }

    /**
     * 执行预处理语句
     * @param $bind
     * @return \PDOStatement
     */
    private function execute($bind)
    {

        $this->option = [];
        $this->bind   = [];

        if($this->chain['show']){

            return $this->sql;

        }

        $this->stmt = $this->db->prepare($this->sql);

        try{

            $this->stmt->execute($bind);

        }catch(\PDOException $e) {

            throw new exception('SQL Execute Error', $e->getMessage(), $this->sql);

        }

        return $this->stmt;

    }

    /**
     * 获取预处理绑定数组
     * @param $data
     * @return array
     */
    private function bind($data)
    {

        foreach ($data as $field => $value) {

            $this->bind[':'.$field] = $value;

        }

        return $this->bind;

    }

    /**
     * 获取set操作字符串
     * @param $data
     * @return string
     */
    private function set($data)
    {

        $this->bind = [];

        $bindString = '';

        foreach ($data as $field => $value) {

            if($this->chain['show']){

                $bindString .= $field . '='. $value . ',';

            }else{

                $bindString .= $field . '=:' . $field . ',';

            }

            $this->bind[':'.$field] = $value;

        }

        return trim($bindString, ',');

    }

    /**
     * 获取操作字符串
     * @return string
     */
    private function option()
    {

        if($this->option['set']){

            $option = ' SET ' . $this->option["set"];

        }

        if($this->option['inner join']){

            $option .= ' INNER JOIN ' . $this->option["inner join"];

        }

        if($this->option['left join']){

            $option .= ' LEFT JOIN ' . $this->option["left join"];

        }

        if($this->option['right join']){

            $option .= ' RIGHT JOIN ' . $this->option["right join"];

        }

        if($this->option['full join']){

            $option .= ' FULL JOIN ' . $this->option["full join"];

        }

        if($this->option['on']){

            $option .= ' ON (' . $this->option["on"] . ')';

        }

        if($this->option['where']){

            $option .= ' WHERE ' . trim($this->option["where"], $this->chain['logic'] . ' ');

        }

        if($this->option['order']){

            $option .= ' ORDER BY ' . $this->option["order"];

        }

        if($this->option['limit']){

            $option .= ' LIMIT ' . $this->option["limit"];

        }

        return $option;

    }

}