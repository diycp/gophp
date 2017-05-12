<?php

namespace gophp\wechat;

use gophp\cache;
use gophp\request;

class base
{
    /**
     * @desc 获取AccessToken
     * @return mixed
     */
    public function getAccessToken($appId, $appSecret) {

        $accessToken = cache::get('base_access_token');

        if(!$accessToken){

            $requestUrl    = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appId}&secret={$appSecret}";

            $requestResult = json_decode(request::curl($requestUrl, 'get'), true);

            $accessToken   = $requestResult['access_token'];

            cache::set('base_access_token', $requestResult['access_token'], $requestResult['expires_in']);

        }

        return $accessToken;

    }

}