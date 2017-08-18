<?php

namespace gophp;

use gophp\traits\call;
use PDO;

class schema
{

    private $db     = null;
    private $stmt   = null;
    private $config = [];

    use call;

    private function __construct()
    {

        $this->db      = db::connect();

        $this->config  = config::get('db');

    }

    // 获取所有表
    protected function getTables()
    {

        $driver = $this->config['driver'];

        $sql    = 'SHOW TABLES FROM ' . $this->config[$driver]['name'];

        $this->stmt = $this->query($sql);

        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);

    }

    // 创建表
    protected function createTable($table, $data)
    {
        //todo
    }

    // 删除表
    protected function dropTable($table)
    {

        $sql = "DROP TABLE IF EXISTS `$table`";

        $this->stmt = $this->query($sql);

        if($this->stmt->rowCount() !== false){

            return true;

        }

        return false;

    }

    // 获取主键字段
    protected function getPK($table)
    {

        $pk  = 'id';

        $sql = "DESC $table";

        $this->stmt = $this->query($sql);

        $fields     = $this->stmt->fetchAll();

        foreach($fields as $field){

            if($field['Key'] == 'PRI'){

                $pk = $field['Field'];

            }

        }

        return $pk;

    }

    // 获取所有字段
    protected function getFields($table)
    {

        $sql = 'SHOW COLUMNS FROM ' . $table;

        $this->stmt = $this->query($sql);

        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);

    }

    // 获取单个字段信息
    protected function getField($table, $field)
    {

        $sql = 'SHOW FULL FIELDS FROM ' . $table;

        $this->stmt = $this->query($sql);

        $fields = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $fieldInfo = [];

        foreach ($fields as $k => $v) {

            if($v['Field'] == $field){

                $fieldInfo = $v;

            }

        }

        // 返回字符串键名全为小写的数组
        return array_change_key_case($fieldInfo, CASE_LOWER);

    }

    // 添加字段
    protected function addField($table, $data)
    {

        $field   = $data['field'];
        $type    = $data['type'];
        $length  = $data['length'];
        $isNull  = $data['is_null'];
        $default = $data['default'];
        $comment = $data['comment'];
        $after   = $data['after'];

        $sql = "ALTER TABLE `$table` add `$field` ";

        switch ($type) {

            case 'varchar':

                $length  = $length ? $length : 255;

                break;

            case 'int':

                $length  = $length ? $length : 10;
                $default = $default ? $default : 0;

                break;

            case 'tinyint':

                $length = $length ? $length : 3;
                $default = $default ? $default : 0;

                break;

            case 'text':

                $length = '';

                break;

            case 'tinytext':

                $length = '';

                break;

            case 'decimal':

                $length = $length ? $length : '10,2';

                break;

            case 'time':

                $length = '';

                break;

            case 'timestamp':

                $length  = '';
                $default = 'CURRENT_TIMESTAMP';

                break;

            default:

                $length = '';
                $default = $default ? $default : '';

                break;

        }

        $length = $length ? '('. $length .')' : '';
        $isNull = $isNull ? true : false;

        $sql    = $sql . $type . $length;

        if(!$isNull){

            $sql = $sql . ' NOT NULL';

        }

        if(isset($default)){

            $sql = $sql . ' DEFAULT ' . $default;

        }

        if(isset($comment)){

            $sql = $sql . ' COMMENT ' . "'$comment'";

        }

        if(isset($after)){

            $sql = $sql . 'AFTER ' . $after;

        }

        $this->stmt = $this->query($sql);

        if($this->stmt->rowCount() !== false){

            return true;

        }

        return false;

    }

    // 修改字段
    protected function editField($table, $data)
    {

        $field   = $data['field'];
        $type    = $data['type'];
        $length  = $data['length'];
        $isNull  = $data['is_null'];
        $default = $data['default'];
        $comment = $data['comment'];
        $after   = $data['after'];

        $sql = "ALTER TABLE `$table` CHANGE COLUMN `$field` `$field` ";

        switch (strtolower($type)) {

            case 'varchar':

                $length  = $length ? $length : 255;

                break;

            case 'int':

                $length  = $length ? $length : 10;
                $default = $default ? $default : 0;

                break;

            case 'tinyint':

                $length = $length ? $length : 3;
                $default = $default ? $default : 0;

                break;

            case 'text':

                $length = '';

                break;

            case 'tinytext':

                $length = '';

                break;

            case 'decimal':

                $length = $length ? $length : '10,2';

                break;

            case 'time':

                $length = '';

                break;

            case 'timestamp':

                $length  = '';
                $default = 'CURRENT_TIMESTAMP';

                break;

            default:

                $length = '';
                $default = $default ? $default : '';

                break;

        }

        $length = $length ? '('. $length .')' : '';
        $isNull = $isNull ? true : false;

        $sql    = $sql . $type . $length;

        if(!$isNull){

            $sql = $sql . ' NOT NULL';

        }

        if(isset($default)){

            $sql = $sql . ' DEFAULT ' . $default;

        }

        if(isset($comment)){

            $sql = $sql . ' COMMENT ' . "'$comment'";

        }

        if(isset($after)){

            $sql = $sql . ' AFTER ' . $after;

        }

        $this->stmt = $this->query($sql);

        if($this->stmt->rowCount() !== false){

            return true;

        }

        return false;

    }

    // 删除字段
    protected function dropField($table, $field){

        $sql  = "ALTER TABLE `$table` DROP `$field`";

        $this->stmt = $this->query($sql);

        if($this->stmt->rowCount() !== false){

            return true;

        }

        return false;

    }

    // 执行原生sql
    private function query($sql)
    {

        try {

            $this->stmt = $this->db->query($sql);

        } catch(\PDOException $e) {

            throw new exception('Query Error', $e->getMessage(), $sql);

        }

        return $this->stmt;

    }

}