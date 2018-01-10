<?php

namespace app;

class book {

    /**
     * 获取当前登录用户id
     * @return mixed
     */
    public static function get_user_id(){

        $user_id = session('user_id');

        return $user_id ? $user_id : 0;

    }

}
