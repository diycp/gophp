<?php

namespace app;

class nav {

    /**
     * 获取当前登录用户id
     * @return mixed
     */
    public static function get_nav_list(){

        $navs =  db('nav')->where('status', '=', 1)->orderBy('sort desc')->findAll();

        $index = array(
            'title' => '首页',
            'alias' => 'index',
            'sort' => '99999',
            'status' => '1',
        );

        array_unshift($navs, $index);

        foreach ($navs as $k=>$nav) {

            if(CONTROLLER_NAME == $nav['alias']){
                $data[$k]['active'] = 1;
            }else{
                $data[$k]['active'] = 0;

            }

            $data[$k]['title'] = $nav['title'];
            $data[$k]['url'] = url($nav['alias']);
        }

        return $data;

    }

    public static function position()
    {
        $nav = CONTROLLER_NAME;
        $id  = ACTION_NAME;

        $data[0]['title'] = '首页';
        $data[0]['url'] = '/';

        if($nav != 'index'){
            $nav = db('nav')->where('alias', '=', $nav)->find();

            $data[1]['title'] = $nav['title'];
            $data[1]['url'] = url($nav['alias']);
        }

        if($info = _uri('article', $id)){
            $data[2]['title'] = $info['title'];
        }

        return $data;
    }

}
