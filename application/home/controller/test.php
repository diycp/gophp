<?php

namespace app\home\controller;

use app\category;
use app\id;
use app\notify;
use app\tree;
use gophp\config;
use gophp\db;
use gophp\helper\url;
use gophp\schema;


class test {

    /**
     * 添加/编辑字段
     */
    public function index(){


        $url = 'http://gocmf.com/mock/lHiSJHmHVq.html?user_id=1.1';

        $a = url::getExtension($url);

        dump($a);


    }



}