<?php

namespace app\home\controller;

use gophp\controller;
use gophp\cookie;
use gophp\request;
use gophp\session;

class index extends controller {

    public function index(){

        $a = $_FILES;
        $b = $_POST;

        $this->ajaxReturn(['code'=>200,'url' => 'http://wx1.sinaimg.cn/mw690/4b4d632fgy1fieobgb1ftj209c08cjse.jpg', 'post'=>$b]);

        $this->ajaxReturn(['code'=>200,'file' => $a, 'post'=>$b]);

    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }


}