<?php

namespace gophp;

use Illuminate\Database\Capsule\Manager as Capsule;
use  Illuminate\Database\Eloquent\Model  as Eloquent;

class model extends Eloquent
{

    public function __construct()
    {

        $capsule = new Capsule();

        // 创建链接
        $capsule->addConnection(config::get('database'));

        // 设置全局静态可访问
        $capsule->setAsGlobal();

        // 启动Eloquent
        $capsule->bootEloquent();

    }

}
