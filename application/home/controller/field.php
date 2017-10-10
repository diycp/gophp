<?php

namespace app\home\controller;

use gophp\request;
use gophp\response;

class field extends auth {

    /**
     * 添加/编辑字段
     */
    public function add(){

        if(request::isAjax()){

            $field  = request::post('field', []);

            $field_id = $field['id'] ? $field['id'] : 0;
            $api_id   = $field['api_id'] ? $field['api_id'] : 0;

            // 检测是否选择接口
            if($api_id){

                $data['api_id'] = $api_id;

            }else{

                response::ajax(['code' => 301, 'msg' => '请选择所属接口']);

            }

            // 检测是否填写字段名称
            if($name = $field['name']){

                $data['name'] = $name;

            }else{

                response::ajax(['code' => 302, 'msg' => '参数名称不能为空']);

            }

            // 检测是否填写字段标题
            if($title = $field['title']){

                $data['title'] = $title;

            }else{

                response::ajax(['code' => 303, 'msg' => '参数标题不能为空']);

            }

            // 检测是否填写字段类型
            if($type = $field['type']){

                $data['type'] = $type;

            }else{

                response::ajax(['code' => 304, 'msg' => '参数类型不能为空']);

            }

            // 检测字段名称是否已存在
            $result = db('field')->show(false)->where('api_id', '=', $api_id)->where('name', '=', $name)->where('id', 'not in', [$field_id])->find();

            if($result){

                response::ajax(['code' => 304, 'msg' => '该参数名称已存在']);

            }

            // 检测是否填写字段简介
            if($intro = $field['intro']){

                $data['intro'] = $intro;

            }

            $data['is_required'] = $field['is_required'];
            $data['method']    = $field['method'];
            $data['user_id']   = $this->user_id;
            $data['add_time']  = date('Y-m-d H:i:s');

            if(\app\field::find($field_id)){
                // 更新操作
                $result = db('field')->where('id', '=', $field_id)->update($data);

                if($result !== false){

                    response::ajax(['code' => 200, 'msg' => '参数更新成功']);

                }

            }else{

                $result = db('field')->add($data);

                if($result){

                    response::ajax(['code' => 200, 'msg' => '参数添加成功']);

                }
            }

        }

    }

    public function request()
    {

        $api_id  = request::get('id', 0);

        $api = _uri('api', $api_id);

        $this->assign('api', $api);

        $this->display('field/request');

    }

    public function response()
    {

        $api_id  = request::get('id', 0);

        $api = _uri('api', $api_id);

        $this->assign('api', $api);

        $this->display('field/response');
    }


}