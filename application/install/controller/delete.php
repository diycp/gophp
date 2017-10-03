<?php

namespace app\install\controller;

use gophp\db;
use gophp\helper\dir;
use gophp\helper\file;
use gophp\request;

class delete extends auth {

    public function index(){


        if(request::isAjax()){

            dir::deleteSubDir(APP_PATH . '/install/');

            response::ajax(['code' => 200, 'msg' => '提交成功']);

        }

    }

}