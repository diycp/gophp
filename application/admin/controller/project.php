<?php

namespace app\admin\controller;

use gophp\controller;
use gophp\page;

class project extends controller {

    public function index()
    {

        $totalRows = db('project')->count();

        $page      = new page($totalRows, 10);

        $projects  = db('project')->show(false)->page($page)->orderBy('id desc')->findAll();

        $this->assign('page', $page);
        $this->assign('projects', $projects);

        $this->display('project/index');

    }

}