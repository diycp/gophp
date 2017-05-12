<?php

namespace gophp\wechat;

use gophp\exception;
use gophp\request;

class user extends base
{

    public $accessToken;
    public $openId;

    public function __construct()
    {

        $oauth = new oauth('snsapi_userinfo');

        $this->accessToken = $oauth->accessToken;

        $this->openId      = $oauth->openId;

    }

    public function getInfo()
    {

        $requestUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={$this->accessToken}&openid={$this->openId}&lang=zh_CN";

        $jsonResult = json_decode(request::curl($requestUrl, 'get'), true);

        if($jsonResult['errcode']){

            throw new exception('Wechat Auth Error', $jsonResult['errmsg']);

        }

        return $jsonResult;

    }

    public function getList()
    {

        $requestUrl = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$this->accessToken}&next_openid=NEXT_OPENID";

        $jsonResult = json_decode(request::curl($requestUrl, 'get'), true);

        if($jsonResult['errcode']){

            throw new exception('Wechat Auth Error', $jsonResult['errmsg']);

        }

        return $jsonResult;

    }

    public function setMarkName($remark)
    {

        $requestUrl = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token={$this->accessToken}";

        $requestData['openid'] = $this->openId;
        $requestData['remark'] = $remark;

        $jsonResult = json_decode(request::curl($requestUrl, 'post', $requestData), true);

        if($jsonResult['errcode']){

            throw new exception('Wechat Auth Error', $jsonResult['errmsg']);

        }

        return true;

    }

}