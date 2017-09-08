<?php

namespace app\home\controller;

class project extends auth {

    public function index(){

        //创建的项目
        $create_projects = db('project')->show(false)->where('user_id', '=', $this->user_id)->findAll();

        //参与的项目
        $join_projects = db('project_user')->join('project', 'left')->show(false)->on('project_user.project_id = project.id')->findAll('project.id as id, project.title as title, project.intro as intro, project_user.add_time as join_time');

        dump($join_projects);

        $this->assign('create_projects', $create_projects);
        $this->assign('join_projects', $join_projects);

        $this->display('project/list');

    }

    /**
     * 添加/编辑项目
     */
    public function add(){

        if(request::isPost()){

            $id = request::post('id', 0);

            $project = db::table('project')->show(false)->find($id);

            if(!$project){

                response::ajax(false);

            }else{

                // 获取项目成员列表
                $project_users = db::table('project_user')->where('project_id', '=', $id)->findAll();
                foreach ($project_users as $project_user) {
                    $user = db::table('user')->find($project_user['user_id']);
                    $users .=  "<span class='picked-user' data-id='{$user[id]}' data-name='{$user[name]}({$user[email]})' data-email='{$user[email]}'>{$user[name]}({$user[email]})<i title='点击删除' class='fa fa-times js_deleteUser'></i></span>";
                }

                $project['users'] = $users;

                response::ajax($project);

            }

        }

    }

    /** 
     * 删除项目
     */
    public function delete(){

        if(request::isPost()){

            $project_id = request::post('project_id', 0);
            $password   = request::post('password', '');

            $password = md5(crypt::encrypt($password));

            $user     = db::table('user')->where('id', '=', $this->user_id)->where('password', '=', $password)->find();

            $project  = db::table('project')->find($project_id);

            if(!$project){

                response::ajax(['code' => 401, 'msg' => '请选择要删除的项目!']);

            }

            if($project && $project['user_id'] !== $this->user_id){

                response::ajax(['code' => 401, 'msg' => '抱歉，你无权操作!']);

            }

            if(!$user){

                response::ajax(['code' => 402, 'msg' => '抱歉，密码错误!']);

            }

            $project = db::table('project')->show(false)->delete($project_id);

            if($project){

                response::ajax(['code' => 200, 'msg' => '删除成功!']);

            }else{

                response::ajax(['code' => 403, 'msg' => $project]);

            }




        }

    }

    /**
     * 项目详情
     * @param $id
     * @param $arguments
     */
    public function __call($id, $arguments)
    {

        $project = db::table('project')->find($id);

        // 判断项目是否存在
        if(!$project){

            response::redirect('project');

        }

        // 判断是否有权限访问项目

        $user = db::table('user')->find($project['user_id']);

        $this->assign('project', $project);
        $this->assign('user', $user);

        $this->display('project/index');

    }

}