<?php

namespace app\home\controller;

use app\config;
use app\member;
use app\notify;
use gophp\page;
use gophp\request;
use gophp\response;
use app\user;

class project extends auth {


    public function index()
    {

        response::redirect('project/select');

    }

    /**
     * 选择项目
     */
    public function select()
    {

        $user_id = $this->user_id;



        //创建的项目
        $create_projects = db('project')->show(false)->where('user_id', '=', $user_id)->findAll();

        //参与的项目
        $join_projects  = db('member')->show(false)->where('user_id', '=', $user_id)->findAll();

        $this->assign('create_projects', $create_projects);
        $this->assign('join_projects', $join_projects);

        $this->display('project/select');

    }

    /**
     * 添加/编辑项目
     */
    public function add(){

        if(request::isAjax()){

            $project  = request::post('project', []);
            $user_ids = request::post('user_ids', '');
            $env      = request::post('env', []);

            $data = [];

            foreach ($env as $k=>$v){
                foreach ($v as $k1=>$v1){
                    $data[$k1][$k] = $v1;
                }
            }

            $project['envs'] = json_encode($data);

            $project_id = $project['id'] ? $project['id'] : 0;

            if(!$project['title']){

                response::ajax(['code' => 301, 'msg' => '项目标题不能为空']);

            }

            if(\app\project::check_title($project['title'], $project_id)){

                response::ajax(['code' => 304, 'msg' => '该项目名称已存在']);

            }

            if(!$project['intro']){

                response::ajax(['code' => 302, 'msg' => '项目简介不能为空']);

            }

            $project['user_id']  = $this->user_id;
            $project['add_time'] = date('Y-m-d H:i:s');

            $user_ids = array_filter(explode(',',$user_ids));

            if(\app\project::get_project_info($project_id)){

                // 更新操作
                $result = \app\project::add($project);

                if($result){

                    $member  = db('member')->where('project_id', '=', $project_id)->delete();

                    if($member !== false){

                        foreach ($user_ids as $user_id){

                            $member = [
                                'user_id'    => $user_id,
                                'project_id' => $project_id,
                                'add_time'   => date('Y-m-d H:i:s')
                            ];

                            member::add($member);

                        }

                    }

                    response::ajax(['code' => 200, 'msg' => '项目更新成功']);

                }else{

                    response::ajax(['code' => 303, 'msg' => '项目更新事失败']);

                }

            }else{
                // 添加操作
                $project_id = \app\project::add($project);

                if($project_id){

                    foreach ($user_ids as $user_id){

                        $member = [
                            'user_id'    => $user_id,
                            'project_id' => $project_id,
                            'add_time'   => date('Y-m-d H:i:s')
                        ];

                        member::add($member);

                    }

                    response::ajax(['code' => 200, 'msg' => '项目添加成功']);

                }
            }

        }else{

            $project_id = get('id', 0);

            $project = \app\project::get_project_info($project_id);

            // 获取项目环境域名
            $envs    = json_decode($project['envs'], true);

            // 获取项目成员
            $members = member::get_member_list($project_id);

            $this->assign('project', $project);
            $this->assign('members', $members);
            $this->assign('envs', $envs);

            $this->display('project/add');

        }

    }

    /**
     * 编辑项目
     */
    public function edit()
    {

        $project_id = request::post('id', 0);

        // 判断项目是否存在
        $project = \app\project::get_project_info($project_id);

        if(!$project){

            $this->error('抱歉，该项目不存在');

        }

        if(!user::is_creater($project_id)){

            $this->error('抱歉，您无权编辑该项目');

        }

        // 获取项目环境域名
        $envs    = json_decode($project['envs'], true);

        // 获取项目成员
        $members = member::get_member_list($project_id);

        $this->assign('project', $project);
        $this->assign('members', $members);
        $this->assign('envs', $envs);

        $this->display('project/edit');

    }

    public function load()
    {

        $project_id = request::post('id', 0);

        // 判断项目是否存在
        $project = _uri('project', $project_id);

        if(!$project){

            $this->error('抱歉，该项目不存在');

        }

        $this->assign('project', $project);

        $this->display('project/load');

    }

    /**
     * 转让项目
     */
    public function transfer(){

        if(request::isAjax()){

            $project_id = request::post('id', 0);
            $password   = request::post('password', '');
            $user_id    = request::post('user_id', 0);

            if(!user::is_creater($project_id)){

                response::ajax(['code' => 301, 'msg' => '抱歉，您无权转让该项目']);

            }

            if(!$project = \app\project::get_project_info($project_id)){

                response::ajax(['code' => 301, 'msg' => '该项目不存在']);

            }

            if(!user::get_user_info($user_id)){

                response::ajax(['code' => 302, 'msg' => '该用户不存在']);

            }

            if(!user::check_password($password)){

                response::ajax(['code' => 303, 'msg' => '抱歉，密码验证失败!']);

            }

            $result = \app\project::add(['id'=>$project_id,'user_id' => $user_id]);

            if($result !== false){

                $notify = array(
                    'res_title' => $project['title'],
                    'res_name'  => 'project',
                    'res_id'    => $project['id'],
                    'project_id'=> $project['id'],
                    'res_option'=> 'transfer',
                );

                notify::add($notify);

                response::ajax(['code' => 200, 'msg' => '转让成功!']);

            }else{

                response::ajax(['code' => 304, 'msg' => '转让失败!']);

            }

        }else{

            $project_id = get('id', 0);

            $project = \app\project::get_project_info($project_id);

            // 获取项目成员
            $members = member::get_member_list($project_id);

            $this->assign('project', $project);
            $this->assign('members', $members);

            $this->display('project/transfer');

        }

    }

    /** 
     * 删除项目
     */
    public function delete(){

        $project_id = request::post('id', 0);
        $password   = request::post('password', '');

        $project    = \app\project::get_project_info($project_id);

        if(!$project){

            response::ajax(['code' => 301, 'msg' => '请选择要删除的项目!']);

        }

        if(!user::check_password($password)){

            response::ajax(['code' => 302, 'msg' => '抱歉，密码验证失败!']);

        }

        if(!user::is_creater($project_id) && !user::is_admin()){

            response::ajax(['code' => 303, 'msg' => '抱歉，您无权删除该项目!']);

        }

        if(\app\project::delete($project_id)){

            response::ajax(['code' => 200, 'msg' => '删除成功!']);

        }else{

            response::ajax(['code' => 403, 'msg' => '删除失败!']);

        }

    }

    /**
     * 退出项目
     */
    public function quit(){

        $project_id = request::post('project_id', 0);
        $user_id    = request::post('user_id', 0);

        if(!$user_id){

            $tip = '退出';

            $user_id = $this->user_id;

        }else{

            $tip = '移除';

        }

        $project = \app\project::get_project_info($project_id);

        if(!$project){

            response::ajax(['code' => 301, 'msg' => '请选择要退出的项目!']);

        }

        if(!user::is_joiner($project_id)){

            response::ajax(['code' => 302, 'msg' => '该会员不是该项目的成员!']);

        }

        $result = db('member')->show(false)->where('project_id', '=', $project_id)->where('user_id', '=', $user_id)->delete();

        if($result){

            response::ajax(['code' => 200, 'msg' => $tip . '成功!']);

        }else{

            response::ajax(['code' => 303, 'msg' => $tip . '失败!']);

        }
    }

    /**
     * 搜索项目
     */
    public function search()
    {

        $totalRows = db('project')->count();
        $page      = new page($totalRows, 10);

        $projects  = db('project')->show(false)->where('allow_search', '=', 1)->page($page)->orderBy('id desc')->findAll();

        $this->assign('page', $page);
        $this->assign('projects', $projects);

        $this->assign('projects', $projects);
        $this->display('project/search');

    }

    /**
     * 项目详情
     * @param $id
     * @param $arguments
     */
    public function __call($id, $arguments)
    {

        $project_id = (int)$id;

        $project    = \app\project::get_project_info($project_id);

        // 判断项目是否存在
        if(!$project){

            $this->error('抱歉，该项目不存在');

        }

        if(!user::has_view_auth($project_id)){

            $this->error('抱歉，您无权查看该项目');

        }

        // 获取项目成员
        $members = member::get_member_list($project_id);

        // 获取项目模块
        $modules = db('module')->where('project_id', '=', $project_id)->findAll();

        // 获取项目环境域名
        $envs    = json_decode($project['envs'], true);

        $this->assign('project', $project);
        $this->assign('members', $members);
        $this->assign('modules', $modules);
        $this->assign('envs', $envs);

        $this->display('project/detail');

    }

}