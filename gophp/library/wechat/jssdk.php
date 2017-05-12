<?php

namespace gophp\wechat;

use gophp\cache;
use gophp\config;
use gophp\exception;
use gophp\helper\str;
use gophp\request;
use gophp\validate;

class jssdk extends base
{

    protected $appId;
    protected $appSecret;
    protected $url;

    public function __construct($url = null)
    {

        $config = config::get('wechat');

        $this->appId     = $config['app_id'];
        $this->appSecret = $config['app_secret'];

        if($url && validate::isUrl($url)){

            $this->url  = $url;

        }else{

            $this->url  = request::getUrl(true);

        }

    }

    public function getSignPackage() {

        $apiTicket = $this->getApiTicket();

        $timestamp = time();

        $nonceStr  = str::random(16);

        $url       = $this->url;

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string    = "jsapi_ticket=$apiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
        );

        return $signPackage;

    }

    private function getApiTicket() {

        $apiTicket = cache::driver('redis')->get('jsapi_ticket');

        if(!$apiTicket){

            $accessToken = $this->getAccessToken($this->appId, $this->appSecret);

            $requestUrl  = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=jsapi";

            $requestResult  = json_decode(request::curl($requestUrl, 'get'), true);

            if($requestResult['errcode'] === 0){

                $apiTicket = $requestResult['ticket'];

                cache::driver('redis')->set('jsapi_ticket', $requestResult['ticket'], $requestResult['expires_in']);

            }else{

                throw new exception('apiTicket Error', $requestResult['errmsg']);

            }

        }

        return $apiTicket;

    }

}