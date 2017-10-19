<?php

namespace app;

class project {

    /**
     * 根据项目id获取项目详情
     * @param $user_id
     */
    public static function get_project_info($project_id)
    {

        if(!$project_id){
            return [];
        }

        return db('project')->show(false)->find($project_id);

    }

    /**
     * 根据项目id获取项目成员数
     * @param $user_id
     */
    public static function get_member_num($project_id)
    {

        if(!$project_id){

            return 0;

        }

        return db('member')->show(false)->where('project_id', '=', $project_id)->count();

    }

    public static function check_title($title, $project_id)
    {

        $project_id = isset($project_id) ? $project_id : 0;

        $result = db('project')->show(false)->where('title', '=', $title)->where('id', 'not in', [$project_id])->find();

        if($result){

            return true;

        }else{

            return false;

        }

    }

    /**
     * 添加/编辑项目
     * @param $data
     * @return bool
     */
    public static function add($data)
    {

        if(!$data || !is_array($data)){

            return false;

        }

        $notify['res_name'] = 'project';

        if($project = project::get_project_info($data['id'])){

            //更新操作
            $result =  db('project')->show(false)->where('id', '=', $project['id'])->update($data);

            if($result !== false){

                $notify = array(
                    'res_title' => $project['title'],
                    'res_name'  => 'project',
                    'res_id'    => $project['id'],
                    'project_id'=> $project['id'],
                    'res_option'=> 'update',
                );

                notify::add($notify);

                return true;

            }else{

                return false;

            }


        }else{

            //新增操作
            $id =  db('project')->show(false)->add($data);

            if($id){

                $notify = array(
                    'res_title' => $data['title'],
                    'res_name'  => 'project',
                    'res_id'    => $id,
                    'project_id'=> $id,
                    'res_option'=> 'insert',
                );

                notify::add($notify);

                return $id;

            }else{

                return false;

            }

        }


    }

    /**
     * 删除项目
     * @param $project_id
     * @return bool
     */
    public static function delete($project_id)
    {

        $project = project::get_project_info($project_id);

        if(!$project){

            return false;

        }

        $result = db('project')->show(false)->delete($project_id);

        if($result){

            $notify = array(
                'res_title' => $project['title'],
                'res_name'  => 'project',
                'res_id'    => $project_id,
                'project_id'=> $project_id,
                'res_option'=> 'delete',
            );

            notify::add($notify);

            return true;

        }else{

            return false;

        }

    }

}