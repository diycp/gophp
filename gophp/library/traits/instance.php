<?php

namespace gophp\traits;

trait instance
{

    private static $instance = null;

    // 获取单例
    final public static function instance($config)
    {

        if (!(self::$instance instanceof self)) {

            self::$instance = new self($config);

        }

        return self::$instance;

    }

    // 禁止克隆
    private function __clone()
    {

    }

}