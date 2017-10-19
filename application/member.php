<?php

namespace app;

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

            return false;

        }

        $notify['res_name'] = 'member';

        if($data['id']){

            //更新操作
            $result =  db('member')->show(false)->where('id', '=', $data['id'])->update($data);

            if($result !== false){

                return true;

            }else{

                return false;

            }


        }else{

            //新增操作
            $id =  db('member')->show(false)->add($data);

            if($id){

                return $id;

            }else{

                return false;

            }

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

            return false;

        }

        $result = db('member')->show(false)->delete($member_id);

        if($result){

            $notify = array(
                'res_title' => _uri('user', $member['user_id'], 'name'),
                'res_name'  => 'member',
                'res_id'    => $member['user_id'],
                'res_option'=> 'delete',
            );

            notify::add($notify);

            return true;

        }else{

            return false;

        }

    }

}