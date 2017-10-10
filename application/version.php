<?php

namespace app;

class version {

    public static function add($data)
    {

        if(!$data || !is_array($data)){

            return false;
        }

        return db('version')->show(false)->add($data);

    }

}