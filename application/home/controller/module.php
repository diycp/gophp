<?php

namespace app\home\controller;

use gophp\request;
use gophp\response;

class module extends auth {

    /**
     * 添加/编辑模块
     */
    public function add(){

        if(request::isAjax()){


            $title = request::post('title', '');
            $intro = request::post('intro', '');

            $module_id   = request::post('module_id', 0);
            $project_id  = request::post('project_id', 0);

            $project = db('project')->find($project_id);

            if($project){

                $data['project_id'] = $project_id;

            }else{

                response::ajax(['code' => 301, 'msg' => '请选择要添加模块的项目']);

            }

            if($title){

                $data['title'] = $title;

            }else{

                response::ajax(['code' => 302, 'msg' => '模块名称不能为空']);

            }

            $module = db('module')->show(false)->where('project_id', '=', $project_id)->where('title', '=', $title)->where('id', 'not in', [$module_id])->find();

            if($module){

                response::ajax(['code' => 304, 'msg' => '该模块名称已存在']);

            }

            if($intro){

                $data['intro'] = $intro;

            }else{

                response::ajax(['code' => 303, 'msg' => '模块简介不能为空']);

            }

            $data['user_id']      = $this->user_id;

            $module = db('module')->find($module_id);

            if($module){
                // 更新操作
                $result = db('module')->where('id', '=', $module_id)->update($data);

                if($result !== false){

                    response::ajax(['code' => 200, 'msg' => '模块更新成功']);

                }

            }else{

                $data['add_time']     = date('Y-m-d H:i:s');

                $result = db('module')->add($data);

                if($result){

                    response::ajax(['code' => 200, 'msg' => '模块添加成功']);

                }
            }

        }else{

            $ids = explode('-', get('id', ''));

            $project_id = $ids[0];
            $module_id  = $ids[1];

            $project_id && $project = db('project')->find($project_id);
            $module_id && $module  = db('module')->find($module_id);

            $this->assign('project', $project);
            $this->assign('module', $module);

            $this->display('module/add');

        }


    }

    /** 
     * 删除模块
     */
    public function delete(){

        $id       = request::post('id', 0);
        $password = request::post('password', '');
        $password = md5(encrypt($password));


        $module   = db('module')->find($id);

        if(!$module){

            response::ajax(['code' => 301, 'msg' => '请选择要删除的模块!']);

        }

        $user = db('user')->where('id', '=', $this->user_id)->where('password', '=', $password)->find();

        if(!$user){

            response::ajax(['code' => 303, 'msg' => '抱歉，密码验证错误!']);

        }

        $result = db('module')->show(false)->delete($id);

        if($result){

            response::ajax(['code' => 200, 'msg' => '删除成功!']);

        }else{

            response::ajax(['code' => 403, 'msg' => '删除失败!']);

        }

    }


}