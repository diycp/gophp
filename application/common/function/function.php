<?php
/**
 * 公共函数库
 */

if (!function_exists('get_ip_address')) {
    function get_ip_address($ip = '', $type = null)
    {
        if(!$ip){

            $ip = \gophp\request::getClientIp();
        }

        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        //调用淘宝接口获取信息
        $json = file_get_contents($url);

        $data = json_decode($json, true);

        if ($data['code']) {

            return $data['data'];

        } else {

            $country = $data['data']['country'];
            $province = $data['data']['region'];
            $city = $data['data']['city'];
            $area = $data['data']['area'];

            if($type == 'country'){

                return $country;

            }elseif($type == 'province'){

                return $province;

            }elseif($type == 'area'){

                return $area;

            }elseif($type == 'city'){

                return $city;

            }else{

                return $country.' '.$area.' '.$province.' '.$city;

            }

        }

    }
}

