<?php

namespace app\admin\controller;

use app\module;
use gophp\db;
use gophp\page;
use gophp\request;
use gophp\response;

class service extends auth {

    public function index(){

        $search     = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'service';

        $sql   = "select * from $table_name order by sort DESC,id DESC ";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $navs = $db->show(false)->query($sql, $pre_rows);

        $this->assign('page', $page);
        $this->assign('navs', $navs);
        $this->assign('search', $search);

        $this->display('service/index');

    }


    public function add()
    {

        if(request::isAjax()){
            $id    = request::post('id', 0);
            $title = request::post('title', '');
            $content = request::post('content', '');
            $sort  = request::post('sort', 0);
            $status = request::post('status', 0);

            $data['title'] = $title;
            $data['content'] = $content;
            $data['sort']   = $sort;
            $data['status'] = $status;
            $data['user_name'] = _uri('user', \app\user::get_user_id(), 'name');

            if($id){

                $result = db('service')->where('id', '=', $id)->update($data);

            }else{

                unset($data['id']);

                $data['add_time'] = date('Y-m-d H:i:s');

                $result = db('service')->add($data);

            }

            if(false !== $result){

                return response::ajax(['code' => 200, 'msg' => '操作成功']);

            }

            return response::ajax(['code' => 300, 'msg' => '操作失败']);


        }else{
            $id = request::get('id', 0);

            $nav = _uri('service', $id);

            $this->assign('nav', $nav);

            $this->display('service/add');
        }

    }

}