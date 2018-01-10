<?php

namespace app\admin\controller;

use app\module;
use gophp\db;
use gophp\page;
use gophp\request;
use gophp\response;

class job extends auth {

    public function index(){

        $search     = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'article';

        $sql   = "select * from $table_name where nav_alias = 'job' order by sort DESC,id DESC ";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $navs = $db->show(false)->query($sql, $pre_rows);

        $this->assign('page', $page);
        $this->assign('navs', $navs);
        $this->assign('search', $search);

        $this->display('job/index');

    }

    public function add()
    {

        if(request::isPost()){
            $id    = request::post('id', 0);
            $title = request::post('title', '');
            $content = request::post('content', '');
            $sort  = request::post('sort', 0);
            $status = request::post('status', 0);

            $data['title'] = $title;
            $data['content'] = $content;
            $data['sort']   = $sort;
            $data['status'] = $status;
            $data['nav_alias'] = 'job';

            if($id){

                $result = db('article')->where('id', '=', $id)->update($data);

            }else{

                unset($data['id']);

                $data['add_time'] = date('Y-m-d H:i:s');

                $result = db('article')->add($data);

            }

            if(false !== $result){

                $url = url('admin/job');

                $this->success('操作成功', $url, 1);


            }

            $this->error('操作失败','', 3);

        }else{

            $id = request::get('id', 0);

            $job = _uri('article', $id);

            $this->assign('job', $job);

            $this->display('job/add');
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

            response::ajax(['code'=> 300, 'msg'=>'要删除的职位不存在']);

        }

        $result = db('article')->delete($id);

        if(!$result){

            response::ajax(['code'=> 301, 'msg'=>'删除失败']);

        }

        response::ajax(['code'=> 200, 'msg'=>'删除成功']);

    }

}