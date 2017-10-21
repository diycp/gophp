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

            // 检测是否填写参数方法
            if($method = $field['method']){

                $data['method'] = $method;

            }else{

                response::ajax(['code' => 304, 'msg' => '参数方法不能为空']);

            }

            // 检测字段名称是否已存在
            if(\app\field::check_name(['api_id' => $api_id, 'name' => $name, 'method' => $method], $field_id)){

                response::ajax(['code' => 304, 'msg' => '该参数名称已存在']);

            }

            // 检测是否填写字段简介
            if($intro = $field['intro']){

                $data['intro'] = $intro;

            }

            if($field['method'] == 1){

                $data['default_value'] = isset($field['default_value']) ? $field['default_value'] : '';

            }elseif($field['method'] == 2){

                $data['default_value'] = \app\field::get_random_value($type, $title);

            }

            $data['method']    = $field['method'];
            $data['is_required'] = $field['is_required'];
            $data['parent_id'] = $field['parent_id'];
            $data['user_id']   = $this->user_id;

            if(\app\field::find($field_id)){
                // 更新操作
                $result = db('field')->show(false)->where('id', '=', $field_id)->update($data);

                if($result !== false){

                    response::ajax(['code' => 200, 'msg' => '参数更新成功']);

                }

            }else{

                $data['add_time']  = date('Y-m-d H:i:s');

                $result = db('field')->add($data);

                if($result){

                    response::ajax(['code' => 200, 'msg' => '参数添加成功']);

                }
            }

        }

    }

    // 添加请求参数页面
    public function request()
    {

        $ids = request::get('id', '');

        list($api_id, $field_id) = explode('-', $ids);

        $field = _uri('field', $field_id);

        $field['api_id'] = $api_id;
        $field['id']     = $field_id;

        $this->assign('field', $field);

        $this->display('field/request/add');

    }

    // 添加响应参数页面
    public function response()
    {

        $ids = request::get('id', '');

        list($api_id, $parent_id, $field_id) = explode('-', $ids);

        $field = _uri('field', $field_id);

        $field['api_id'] = $api_id;
        $field['parent_id'] = $parent_id;
        $field['id']     = $field_id;

        $this->assign('field', $field);

        $this->display('field/response/add');
    }

    // ajax载入参数列表
    public function load()
    {

        $method = request::post('method', 0);
        $api_id = request::post('api_id', 0);

        $fields = \app\field::get_field_list($api_id, $method);

        $api    = _uri('api', $api_id);

        $this->assign('api', $api);

        if($method == 1){

            $this->assign('request_fields', $fields);
            $this->display('field/request/load');

        }elseif($method == 2){

            $this->assign('response_fields', $fields);
            $this->display('field/response/load');

        }

    }

    /**
     * 删除参数
     */
    public function delete(){

        $id = request::post('id', 0);

        $field = _uri('field', $id);

        if(!$field){

            response::ajax(['code' => 301, 'msg' => '请选择要删除的参数!']);

        }

        $result = db('field')->show(false)->delete($id);

        if($result){

            response::ajax(['code' => 200, 'msg' => '删除成功!']);

        }else{

            response::ajax(['code' => 403, 'msg' => '删除失败!']);

        }

    }

}