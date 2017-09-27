<?php

namespace app\admin\controller;

use gophp\controller;

class project extends controller {

    public function index()
    {

        $projects = db('project')->findAll();

        $this->assign('projects', $projects);

        $this->display('project/index');

    }

}