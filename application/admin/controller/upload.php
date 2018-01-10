<?php

namespace app\admin\controller;


use gophp\response;

class upload extends auth {


    public function image()
    {

        $upload = \gophp\upload::instance();

        $upload->max_size = 4;

        if($upload->exist('imgFile')){
            $src = $upload->file('imgFile');

            if($error = $upload->getError()){

                response::ajax(['error'=> 300, 'msg' => $error]);

            }

            response::ajax(['error'=> 0, 'url' => $src]);


        }

    }


    /**
     * 删除
     */
    public function delete()
    {

        $id = request::post('id', 0);

        $focus = _uri('focus', $id);

        if(!$focus){

            response::ajax(['code'=> 300, 'msg'=>'要删除的文件不存在']);

        }

        $result = db('focus')->delete($id);

        if(!$result){

            response::ajax(['code'=> 301, 'msg'=>'删除失败']);

        }

        $file = ROOT_PATH . $focus['src'];

        file::delete($file);

        response::ajax(['code'=> 200, 'msg'=>'删除成功']);

    }

}