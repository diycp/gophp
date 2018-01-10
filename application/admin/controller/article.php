<?php

namespace app\admin\controller;

use gophp\db;
use gophp\page;
use gophp\request;
use gophp\response;
use gophp\upload;

class article extends auth {

    public function index()
    {

        $search = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'article';

        $where = 'nav_alias = "news"' ;

        if($title = trim($search['title'])){

            $where .= "and title like '%{$title}%'";

        }

        if($status = trim($search['status'])){

            $where .= "and status = $status";

        }

        $where = $where ? ' where ' . $where : '';

        $sql   = "select * from $table_name $where order by id desc";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $news = $db->show(false)->query($sql, $pre_rows);

        $this->assign('search', $search);
        $this->assign('page', $page);
        $this->assign('news', $news);

        $this->display('article/index');

    }

    public function add()
    {

        if(request::isPost()){

            $news = request::post('news', []);

            $upload = upload::instance();

            $news['nav_alias'] = 'news';

            $upload->max_size = 2;

            if($upload->exist('cover')){
                $cover = $upload->file('cover');

                $upload->watermark($cover, '/static/default.png');

                if($error = $upload->getError()){

                    $this->error($error, 3);

                }

                $news['cover'] = $cover;

            }

            if($id = $news['id']){

                $result = db('article')->where('id', '=', $id)->update($news);

            }else{

                $result = db('article')->add($news);

            }

            if(false !== $result){

                $url = url('admin/article');

                $this->success('操作成功', $url, 1);

            }

            $this->error('操作失败','', 3);

        }else{

            $id = request::get('id', 0);

            $news = _uri('article', $id);

            $navs = db('nav')->where('status', '=', 1)->orderBy('sort desc')->findAll();

            $this->assign('news', $news);
            $this->assign('navs', $navs);

            $this->display('article/add');
        }

    }

    /**
     * 删除
     */
    public function delete()
    {

        $id = request::post('id', 0);

        $focus = _uri('article', $id);

        if(!$focus){

            response::ajax(['code'=> 300, 'msg'=>'要删除的动态不存在']);

        }

        $result = db('article')->delete($id);

        if(!$result){

            response::ajax(['code'=> 301, 'msg'=>'删除失败']);

        }

        response::ajax(['code'=> 200, 'msg'=>'删除成功']);

    }


}