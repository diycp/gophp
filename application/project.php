<?php

namespace app;

class project {

    /**
     * 根据项目id获取项目详情
     * @param $user_id
     */
    public static function get_project_info($project_id)
    {

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

    /**
     * 根据项目id获取项目成员数
     * @param $user_id
     */
    public static function get_last_version($project_id)
    {

        if(!$project_id){

            return 0;

        }

        return db('version')->show(false)->where('project_id', '=', $project_id)->value('id');

    }

    public static function add($data)
    {

        if(!$data || !is_array($data)){

            return false;
        }

        if($data['id']){
            //更新操作
            return db('project')->show(false)->where('id', '=', $data['id'])->update($data);
        }

        return db('project')->show(false)->add($data);

    }

}