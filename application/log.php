<?php

namespace app;

class log {


    public static function login($project_id)
    {

        if(!$project_id){
            return [];
        }

        return db('project')->show(false)->find($project_id);

    }

    public static function project($data)
    {

        $user = user::get_user_info();

        $data['user_id']   = $user['id'];
        $data['user_name'] = $user['name'] . '(' . $user['email'] . ')';
        $data['add_time']  = date('Y-m-d H:i:s');

        return db('project_log')->show(false)->add($data);

    }


}