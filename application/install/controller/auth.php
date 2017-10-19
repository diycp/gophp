<?php

namespace app\install\controller;

use gophp\controller;
use gophp\helper\file;

class auth extends controller {

    public function __construct()
    {

        if(file::exists(APP_PATH.'/install/cache/install.lock')){
            exit('<stong>程序已经安装，请勿重复安装</stong>');
        }

    }

}