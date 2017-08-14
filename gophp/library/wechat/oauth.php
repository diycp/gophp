<?php

namespace gophp\wechat;

use gophp\cache;
use gophp\config;
use gophp\exception;
use gophp\request;
use gophp\response;

class oauth
{

    public $appId;
    public $appSecret;
    public $accessToken;
    public $openId;
    public $unionId;

    public function __construct($scope = 'snsapi_userinfo')
    {

        $config = config::get('wechat');

        $this->appId     = $config['app_id'];
        $this->appSecret = $config['app_secret'];

        $callback = urlencode(request::getUrl(true));

        $code     = request::get('code', '');

        if(!$code){

            $jumpUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appId}&redirect_uri={$callback}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";

            response::redirect($jumpUrl);

        }

        $this->getAccessToken($code);

    }

    private function getAccessToken($code)
    {

        $this->accessToken = cache::get('auth_access_token');
        $this->openId      = cache::get('auth_openid');

        if(!$this->accessToken){

            $requestUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";

            $requestResult = json_decode(request::curl($requestUrl, 'get'), true);

            if($requestResult['errcode']){

                throw new exception('Wechat Auth Error', $requestResult['errmsg']);

            }

            $this->accessToken = $requestResult['access_token'];
            $this->openId      = $requestResult['openid'];
            $this->unionId     = $requestResult['unionid'];

            cache::set('auth_access_token', $this->accessToken, $requestResult['expires_in']);
            cache::set('auth_openid', $this->openId, $requestResult['expires_in']);
            cache::set('auth_unionid', $this->unionId, $requestResult['expires_in']);

        }

    }

}