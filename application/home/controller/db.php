<?php

namespace app\home\controller;

use gophp\schema;

class db extends auth {

    public function index()
    {

        $filed_list = schema::instance()->getFieldList();

        $this->assign('filed_list', $filed_list);
        $this->display('db/index');

    }

}