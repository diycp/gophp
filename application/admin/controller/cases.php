<?php

namespace app\admin\controller;

use gophp\db;
use gophp\helper\file;
use gophp\page;
use gophp\request;
use gophp\response;
use gophp\upload;

class cases extends auth {

    public function index(){

        $search     = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'article';

        $where = 'nav_alias = "case"' ;


        if($title = trim($search['title'])){

            $where .= " and title like '%{$title}%'";

        }

        if($status = trim($search['status'])){

            $where .= " and status = $status";

        }

        $where = $where ? ' where ' . $where : '';

        $sql   = "select * from $table_name $where order by id desc";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $cases = $db->show(false)->query($sql, $pre_rows);

        $this->assign('page', $page);
        $this->assign('cases', $cases);
        $this->assign('search', $search);

        $this->display('case/index');

    }


    public function add()
    {

        if(request::isPost()){

            $id    = request::post('id', 0);
            $title = request::post('title', '');
            $intro= request::post('intro', '');
            $content = request::post('content', '');
            $status = request::post('status', 0);

            $upload = upload::instance();

            $upload->max_size = 2;

            if($upload->exist('cover')){
                $src = $upload->file('cover');

                if($error = $upload->getError()){

                    $this->error($error, 3);

                }

                $data['cover'] = $src;

            }

            $data['title'] = $title;
            $data['intro'] = $intro;
            $data['content'] = $content;
            $data['status'] = $status;
            $data['nav_alias'] = 'case';

            if($id){

                $result = db('article')->where('id', '=', $id)->update($data);

            }else{

                $data['add_time'] = date('Y-m-d H:i:s');

                $result = db('article')->add($data);

            }


            if(false !== $result){

                $this->success('操作成功', url('admin/cases'), 2);

            }

            $this->error('操作失败', 3);

        }else{


            $id = request::get('id', 0);

            $news = _uri('article', $id);

            $this->assign('news', $news);

            $this->display('case/add');
        }

    }


    /**
     * 删除
     */
    public function delete()
    {

        $id = request::post('id', 0);

        $focus = _uri('focus', $id);

        if(!$focus){

            response::ajax(['code'=> 300, 'msg'=>'要删除的文件不存在']);

        }

        $result = db('focus')->delete($id);

        if(!$result){

            response::ajax(['code'=> 301, 'msg'=>'删除失败']);

        }

        $file = ROOT_PATH . $focus['src'];

        file::delete($file);

        response::ajax(['code'=> 200, 'msg'=>'删除成功']);

    }

}