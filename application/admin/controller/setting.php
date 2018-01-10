<?php

namespace app\admin\controller;

use app\config;
use gophp\request;
use gophp\response;
use gophp\upload;

class setting extends auth {

    /**
     * 管理配置
     */
    public function index()
    {
        if(request::isPost()){

            $config = request::post('config', []);

            if(!$config){

                response::ajax(['code' => 300, 'msg' => '缺失必要参数']);

            }

            $upload = upload::instance();

            $upload->max_size = 2;

            if($upload->exist('kefu_qrcode')){
                $src = $upload->file('kefu_qrcode');

                if($error = $upload->getError()){

                    $this->error($error, 3);

                }

                $config['kefu_qrcode'] = $src;

            }

            if(db('config')->find()){

                $result = db('config')->update(['config' => json_encode($config, JSON_UNESCAPED_UNICODE)]);

            }else{

                $result = db('config')->add(['config' => json_encode($config, JSON_UNESCAPED_UNICODE)]);

            }

            if($result !== false){

                $this->success('操作成功', '', 2);

            }

            $this->error('操作失败', '', 3);


        }else{

            $config = config::get_config_value();

            $this->assign('config', $config);
            $this->display('setting/add');

        }

    }


}