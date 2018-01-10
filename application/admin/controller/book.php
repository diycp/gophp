<?php

namespace app\admin\controller;

use app\module;
use gophp\db;
use gophp\page;
use gophp\request;
use gophp\response;

class book extends auth {

    public function index(){

        $search     = request::get('search', []);

        $db = db::instance();

        $table_suffix = $db->suffix;
        $table_name   = $table_suffix .'book';


        if($name = $search['name']){

            $where = "(name like '%{$name}%') ";

        }

        if($phone = $search['phone']){

            $where = "(phone like '%{$phone}%') ";

        }

        if($deal_status = $search['deal_status']){

            $where = $where ? $where .= ' and ' : '';

            $where .= "deal_status = '{$deal_status}' ";

        }

        $where = $where ? ' where ' . $where : '';

        $sql   = "select * from $table_name $where order by id DESC ";

        $total = count($db->query($sql));

        $pre_rows = 10;

        $page  = new page($total, $pre_rows);

        $books = $db->show(false)->query($sql, $pre_rows);

        $this->assign('page', $page);
        $this->assign('books', $books);
        $this->assign('search', $search);

        $this->display('book/index');

    }

    /**
     * 处理预约
     */
    public function deal()
    {

        $id     = request::post('id', 0);
        $remark = request::post('deal_remark', '');


        if(!$id || !$remark){
            response::ajax(['code' => 300, 'msg' => '缺少必要参数']);

        }

        $data['deal_status']      = 2;
        $data['deal_remark'] = $remark;

        $result = db('book')->show(false)->where('id', '=', $id)->update($data);


        if($result !== false){

            response::ajax(['code' => 200, 'msg' => '预约处理成功!']);

        }else{

            response::ajax(['code' => 500, 'msg' => '预约处理失败!']);

        }

    }

}