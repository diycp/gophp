<?php

namespace app\admin\controller;

use gophp\schema;

class index  extends auth {

    public function index(){

        $user   = \app\user::get_user_info();

        $last_login = \app\user::get_last_login();

        $system = [
            'gophp_version' => GOPHP_VERSION,
            'php_version'   => PHP_VERSION,
            'mysql_version' => schema::instance()->version(),
        ];

        $this->assign('user', $user);
        $this->assign('last_login', $last_login);
        $this->assign('system', $system);

        $this->display('index');

    }

    public function down()
    {

        $dst_path = '../static//image/default.png';
        $src_path = UPLOAD_PATH . '/banner1.jpg'.

        //获取水印图像信息
        $info = getimagesize($dst_path);

        dump($info);exit;

        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
        //获取水印图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);

        dump($dst_path);exit;

        //将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
        imagecopymerge($dst, $src, 10, 10, 0, 0, $src_w, $src_h, 30);

        //如果水印图片本身带透明色，则使用imagecopy方法
        imagecopy($dst, $src, 10, 10, 0, 0, $src_w, $src_h);

        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
            case 1://GIF
                header('Content-Type: image/gif');
                imagegif($dst);
                break;
            case 2://JPG
                header('Content-Type: image/jpeg');
                imagejpeg($dst);
                break;
            case 3://PNG
                header('Content-Type: image/png');
                imagepng($dst);
                break;
            default:
                break;
        }

        imagedestroy($dst);
        imagedestroy($src);
    }

}