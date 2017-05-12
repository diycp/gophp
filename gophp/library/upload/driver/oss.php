<?php

namespace gophp\upload\driver;

use gophp\traits\instance;
use gophp\upload\driver;

class oss extends driver {

    use instance;

    public function file($viewFile)
    {
        echo 'oss file';
        // TODO: Implement file() method.
    }

    public function getError()
    {
        // TODO: Implement getError() method.
    }


}