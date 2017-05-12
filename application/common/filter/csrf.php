<?php

namespace app\common\filter;

class csrf
{

    public function run()
    {

        return 'csrf error';

    }

    public function error()
    {
        return '出错了';
    }


}
