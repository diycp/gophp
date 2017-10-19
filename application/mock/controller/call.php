<?php

namespace app\mock\controller;

use gophp\controller;

class call extends controller {

    public $id;

    // 获取接口id
    public function __construct()
    {
        $this->id = (int)$this->controlloer;

        $api = _uri('api', $this->id);

        dump($api);

        if(!$api){
            echo '该接口不存在';
        }

    }

    // 获取接口环境
    public function __call($name, $arguments)
    {

        echo $this->id;


    }

}