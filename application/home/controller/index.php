<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\request;
use gophp\session;

class index extends controller {

    public function index(){

        $url = 'http://47.93.48.39:8081/rest/binCodeService/getBinCodeById';

        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];

        if($headers && is_array($headers)){

            foreach ($headers as $k => $header) {
                $a = $k . ':' . $header . ',';
            }




        }

//        dump($a);

        $a = request::curl($url, 'post', (['binNo' => '6214850116292548']), ['Content-type' => 'application/x-www-form-urlencoded']);

        dump($a);

        cookie::instance()->set('cookie', ['name' => 'lll'], 300);

        $this->display();

    }


}