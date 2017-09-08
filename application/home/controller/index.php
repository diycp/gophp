<?php

namespace app\home\controller;

use gophp\controller;
use gophp\session;


class index extends auth {

    public function index(){

        $a = 'project.a as a,project.a as b';

        $arguments = explode(',', $a);


        foreach ($arguments as $argument) {

            $data[] = 'doc_' . trim($argument);

        }

        dump($data);


    }

}