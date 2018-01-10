<?php

namespace app\admin\controller;

use gophp\db;
use gophp\helper\file;
use gophp\page;
use gophp\request;
use gophp\response;
use gophp\upload;

class focus extends auth {

    public function index(){

        $search     = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'focus';

        $sql   = "select * from $table_name order by sort DESC,id DESC ";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $focuses = $db->show(false)->query($sql, $pre_rows);

        $this->assign('page', $page);
        $this->assign('focuses', $focuses);
        $this->assign('search', $search);

        $this->display('focus/index');

    }


    public function add()
    {

        if(request::isPost()){

            $id    = request::post('id', 0);
            $title = request::post('title', '');
            $url = request::post('url', '');
            $sort  = request::post('sort', 0);
            $status = request::post('status', 0);

            $upload = upload::instance();

            $upload->max_size = 2;

            if($upload->exist('src')){
                $src = $upload->file('src');

                if($error = $upload->getError()){

                    $this->error($error, 3);

                }

                $data['src'] = $src;

            }

            $data['title'] = $title;
            $data['url'] = $url;
            $data['sort']   = $sort;
            $data['status'] = $status;
            $data['user_name'] = _uri('user', \app\user::get_user_id(), 'name');

            if($id){

                $result = db('focus')->where('id', '=', $id)->update($data);

            }else{

                $data['add_time'] = date('Y-m-d H:i:s');

                $result = db('focus')->add($data);

            }


            if(false !== $result){

                $this->success('操作成功', url('admin/focus'), 2);

            }

            $this->error('操作失败', 3);

        }else{


            $id = request::get('id', 0);

            $focus = _uri('focus', $id);

            $this->assign('focus', $focus);

            $this->display('focus/add');
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