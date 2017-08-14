<?php
/**
 * 异常基类
 * Auth:勾国印
 * Blog:www.gouguoyin.cn
 */

namespace gophp;

class exception extends \Exception
{

    protected $title;
    protected $sql;

    public function __construct($title, $message, $sql, $code)
    {

        parent::__construct($message, $code);

        $this->title = $title;
        $this->sql   = $sql;

    }

    public function getTitle()
    {

        return $this->title;

    }

    public function getSQL()
    {

        return $this->sql;

    }

}