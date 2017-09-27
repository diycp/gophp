<?php

namespace app\home\controller;

use gophp\request;
use gophp\response;

class version extends auth {

    /**
     * 添加/编辑版本
     */
    public function add(){

        if(request::isAjax()){

            $project_id = request::post('project_id', 0);
            $version_id = request::post('version_id', 0);
            $name    = request::post('name', '');

            $project = db('project')->find($project_id);

            if($project){

                $data['project_id'] = $project_id;

            }else{

                response::ajax(['code' => 301, 'msg' => '请选择要添加模块的项目']);

            }

            if($name){

                $data['name'] = $name;

            }else{

                response::ajax(['code' => 302, 'msg' => '版本名称不能为空']);

            }

            $version = db('version')->show(false)->where('project_id', '=', $project_id)->where('name', '=', $name)->where('id', 'not in', [$version_id])->find();

            if($version){

                response::ajax(['code' => 304, 'msg' => '该版本名称已存在']);

            }

            $data['user_id']      = $this->user_id;
            $data['add_time']     = date('Y-m-d H:i:s');

            $version = db('version')->find($version_id);

            if($version){
                // 更新操作
                $result = db('version')->where('id', '=', $version_id)->update($data);

                if($result !== false){

                    response::ajax(['code' => 200, 'msg' => '版本更新成功']);

                }

            }else{

                $result = db('version')->add($data);

                if($result){

                    response::ajax(['code' => 200, 'msg' => '版本添加成功']);

                }
            }

        }else{

            $ids = explode('-', get('id', ''));

            $project_id = $ids[0];
            $version_id = $ids[1];

            $project_id && $project = db('project')->find($project_id);
            $version_id && $version = db('version')->find($version_id);

            $this->assign('project', $project);
            $this->assign('version', $version);

            $this->display('version/add');

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


    public function quit(){

        $id = request::post('id', 0);

        $project  = db('project')->find($id);

        if(!$project){

            response::ajax(['code' => 301, 'msg' => '请选择要退出的项目!']);

        }

        $result = db('project_user')->show(false)->where('project_id', '=', $id)->where('user_id', '=', $this->user_id)->delete();

        if($result){

            response::ajax(['code' => 200, 'msg' => '退出成功!']);

        }else{

            response::ajax(['code' => 403, 'msg' => '退出失败!']);

        }
    }

    /**
     * 项目详情
     * @param $id
     * @param $arguments
     */
    public function __call($id, $arguments)
    {

        $project = db('project')->find($id);

        // 判断项目是否存在
        if(!$project){

            response::redirect('project');

        }

        // 获取项目成员
        $users = db('project_user')->where('project_id', '=', $id)->findAll();

        $this->assign('project', $project);
        $this->assign('users', $users);

        $this->display('project/index');

    }

}