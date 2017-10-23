<?php

namespace app;

use gophp\db;
use gophp\response;

class member {

    /**
     * 根据成员id获取成员详情
     * @param $user_id
     */
    public static function get_member_info($member_id)
    {

        if(!$member_id){
            return [];
        }

        return db('member')->show(false)->find($member_id);

    }

    public static function get_member_list($project_id)
    {

        return db('member')->show(false)->where('project_id', '=', $project_id)->orderBy('id desc')->findAll();

    }

    /**
     * 添加/编辑成员
     * @param $data
     * @return bool
     */
    public static function add($data)
    {

        if(!$data || !is_array($data)){

            response::ajax(['code' => 300, 'msg' => '缺少必要参数']);

        }

        $member_id = $data['id'] ? $data['id'] : 0;

        $member  = \app\member::get_member_info($member_id);

        $user    = \app\user::get_user_info($data['user_id']);
        $project = \app\project::get_project_info($data['project_id']);

        if($member){

            //更新操作
            $result =  db('member')->show(false)->where('id', '=', $member_id)->update(['auths' => $data['auths']]);

            if($result === false){

                response::ajax(['code' => 303, 'msg' => '成员权限更新失败']);

            }

            if($member['auths'] != $data['auths']) {
                //记录日志
                $log = [
                    'project_id' => $member['project_id'],
                    'type'       => '更新',
                    'object'     => '成员',
                    'content'    => '将成员权限由<code>' . member::get_auths_title($member['auths']) . '</code>修改为<code>' . member::get_auths_title($data['auths']) . '</code>',
                ];

                log::project($log);
            }

            response::ajax(['code' => 200, 'msg' => '成员权限更新成功']);

        }else{

            //新增操作
            if(!$user){

                response::ajax(['code' => 301, 'msg' => '该用户不存在']);

            }

            if(!$project){

                response::ajax(['code' => 302, 'msg' => '该项目不存在']);

            }

            $data['add_time'] = date('Y-m-d H:i:s');
            $id =  db('member')->show(false)->add($data);

            if(!$id){

                response::ajax(['code' => 303, 'msg' => '成员添加失败']);

            }

            //记录日志
            $user = user::get_user_info($data['user_id']);
            $log = [
                'project_id' => $data['project_id'],
                'type'       => '添加',
                'object'     => '成员',
                'content'    => '新增成员<code>' . $user['name'] .'('. $user['email'] . ')</code>',
            ];

            log::project($log);

            response::ajax(['code' => 200, 'msg' => '成员添加成功']);

        }


    }

    /**
     * 删除成员
     * @param $project_id
     * @return bool
     */
    public static function delete($member_id)
    {

        $member = self::get_member_info($member_id);

        if(!$member){

            response::ajax(['code' => 301, 'msg' => '该成员不存在!']);

        }

        if(!user::is_creater($member['project_id']) && !user::is_admin()){

            response::ajax(['code' => 302, 'msg' => '抱歉，您无权操作!']);

        }

        $result = db('member')->show(false)->delete($member_id);

        if(!$result){

            response::ajax(['code' => 303, 'msg' => '成员移除失败']);

        }

        //记录日志
        $user = user::get_user_info($member['user_id']);
        $log = [
            'project_id' => $member['project_id'],
            'type'       => '移除',
            'object'     => '成员',
            'content'    => '移除成员<code>' . $user['name'] .'('. $user['email'] . ')</code>',
        ];

        log::project($log);

        response::ajax(['code' => 200, 'msg' => '成员移除成功']);

    }

    public static function get_auths_title($auths)
    {

        if(!$auths){

            return '';

        }

        $auth_list = explode(',', $auths);

        $title  = '';

        foreach ($auth_list as $auth){
            if($auth == 1){
                $title .= '查看、';
            }
            if($auth == 2){
                $title .= '编辑、';
            }
            if($auth == 3){
                $title .= '删除、';
            }
        }

        return trim($title, '、');

    }

}