<?php

namespace app\home\model;

class project {

    /**
     * 根据项目id获取项目详情
     * @param $user_id
     */
    public static function get_project_info($project_id)
    {

        return db('project')->show(false)->where('id', '=', $project_id)->find();

    }

}