<?php

namespace app\home\controller;

use gophp\controller;
use gophp\helper\url;

class index extends controller {

    public function index(){

        echo url::base64_encode('http://gophp.juzifenqi.com/?debug=true');

        echo url::base64_decode('aHR0cDovL2dvcGhwLmp1emlmZW5xaS5jb20vP2RlYnVnPXRydWU');

        $this->display();

    }


}