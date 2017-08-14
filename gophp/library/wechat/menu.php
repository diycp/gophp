<?php

namespace gophp\wechat;

use gophp\cache;
use gophp\config;
use gophp\exception;
use gophp\helper\str;
use gophp\request;
use gophp\validate;

class menu extends base
{

    protected $appId;
    protected $appSecret;
    protected $url;

    public function __construct($url = null)
    {

        $config = config::get('wechat');

        $this->appId     = $config['AppID'];
        $this->appSecret = $config['AppSecret'];

        if($url && validate::isUrl($url)){

            $this->url  = $url;

        }else{

            $this->url  = request::getUrl(true);

        }

    }

    /**
     * @desc 创建菜单
     * @param $data
     * @return mixed
     */
    public function create($data) {

        $accessToken = $this->getAccessToken();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $requestUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$accessToken";

        $jsonResult = json_decode(request::curl($requestUrl, 'get'));

        $data = '{
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';

        $a = request::curl($requestUrl, 'post', $data);

        dump($a);



    }



}