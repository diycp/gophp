<?php

namespace app;

class article {

    public static function get_url($id){

        $article = _uri('article', $id);

        if(!$article){
            return ;
        }

        if($article['jump_url']){

            return $article['jump_url'];
        }

        $alias = $article['nav_alias'];

        return url($alias .'/'.$id);

    }

    public static function get_cover($id){

        $article = _uri('article', $id);

        if(!$article){
            return ;
        }

        $cover = $article['cover'];

        if(!$cover){
            return  '/static/image/default.png';
        }

        return $cover;

    }

    public static function get_nav_title($id)
    {

        $article = _uri('article', $id);

        if(!$article){
            return ;
        }

        return _uri('nav', $article['nav_id'], 'title');

    }

    public static function get_recommend_title($id)
    {

        $article = _uri('article', $id);

        if(!$article){
            return ;
        }

        switch ($article['recommend']) {
            case 'index':
                return '首页';
                break;
            case 'top':
                return '头条';
                break;
            case 'focus':
                return '幻灯片';
                break;
        }


    }

    public static function get_nav_url($id)
    {

        $article = _uri('article', $id);

        if(!$article){
            return ;
        }

        return _uri('nav', $article['nav_id'], 'alias') . '.html';

    }

    public static function get_list($limit = 10, $type = null){

        if($type == 'hot'){

            $articles =  db('article')->where('status', '=', 1)->limit($limit)->orderBy('hits desc')->findAll();

        }elseif($type == 'rand'){

            $articles =  db('article')->where('status', '=', 1)->limit($limit)->orderBy('rand()')->findAll();

        }elseif($type){

            $articles =  db('article')->where('recommend', '=', $type)->where('status', '=', 1)->limit($limit)->orderBy('id desc')->findAll();

        }else{

            $articles =  db('article')->where('status', '=', 1)->where('recommend', '=', '')->limit($limit)->orderBy('id desc')->findAll();

        }

        return $articles;

    }


}