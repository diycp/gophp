<?php

namespace app;

class focus {

    /**
     * 获取当前登录用户id
     * @return mixed
     */
    public static function get_focus_list(){

       return db('focus')->where('status', '=', 1)->orderBy('sort desc')->findAll();

    }

}
