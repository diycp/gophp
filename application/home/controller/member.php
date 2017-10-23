<?php

namespace app\home\controller;

use gophp\request;
use gophp\response;

class member extends auth {

    /**
     * 添加/编辑成员
     */
    public function add(){

        if(request::isAjax()){

            $member_id  = request::post('id', 0);
            $user_id    = request::post('user_id', 0);
            $project_id = request::post('project_id', 0);
            $auth = request::post('auth', []);

            $auths = implode(',', $auth);

            $member = [
                'auths'      => $auths,
                'id'         => $member_id,
                'project_id' => $project_id,
                'user_id'    => $user_id,
            ];

            $result = \app\member::add($member);

            if($result){

                response::ajax(['code' => 200, 'msg' => '操作成功']);

            }else{

                response::ajax(['code' => 303, 'msg' => '操作失败']);

            }

        }else{

            $ids = request::get('id', '');

            list($project_id, $member_id) = explode('-', $ids);

            $member = \app\member::get_member_info($member_id);

            $member['project_id'] = $project_id;

            $member['user'] = \app\user::get_user_info($member['user_id']);

            $auths = explode(',', $member['auths']);

            $this->assign('auths', $auths);
            $this->assign('member', $member);

            $this->display('member/add');

        }

    }

    /**
     * 删除成员
     */
    public function delete(){

        $member_id = request::post('member_id', 0);

        $result = \app\member::delete($member_id);

        response::ajax(['code' => $result['code'], 'msg' => $result['msg']]);

    }

}