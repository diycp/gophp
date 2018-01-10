<?php

namespace app;

class config {

    public static function get_config_value($config_name = null, $show=true){

        $config = db('config')->value('config');

        $config = json_decode($config, true);

        if($config_name == 'copyright' && $show){

            return $config[$config_name] . '  技术支持:<a href="http://www.gouguoyin.cn/about.html" target="_blank">勾国磊</a> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=245629560&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:245629560:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>';

        }

        return $config_name ? $config[$config_name] : $config;

    }

    public static function get_project_config($field = null)
    {

        $project_config = config('project');

        return $field ? $project_config[$field] : $project_config;

    }


}