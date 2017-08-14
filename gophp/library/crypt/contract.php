<?php
/**
 * crpty契约
 */
namespace gophp\crypt;

abstract class contract
{

    protected $config;

    /**
     * 加密
     * @param $str
     * @return mixed
     */
    abstract function encrypt($str);

    /**
     * 解密
     * @param $str
     * @return mixed
     */
    abstract function decrypt($str);

}