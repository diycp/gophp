<?php

namespace app\home\controller;

use gophp\controller;
use gophp\db;
use gophp\mail;
use gophp\request;
use gophp\route;
use Workerman\Worker;


class index extends controller {

    public function index(){

        $task = new Worker();
        $task->count = 1;

        $task->onWorkerStart = function($task)
        {
            // 每2.5秒执行一次
            $time_interval = 2.5;
            Timer::add($time_interval, function()
            {
                echo "task run\n";
            });
        };

        Worker::runAll();

    }

}