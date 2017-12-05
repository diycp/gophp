<?php

namespace app\home\filter;

class csrf
{

    public function handler()
    {

        return 'csrf error';

    }

    public function error()
    {
        return '出错了';
    }


}
