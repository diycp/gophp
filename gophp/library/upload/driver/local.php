<?php

namespace gophp\upload\driver;

use gophp\upload\contract;

class local extends contract {

    public function __construct($config)
    {

        $this->config = $config;

    }

    /**
     * 上传文件
     * @param $inputName 上传框name
     * @return bool|string
     */
    public function file($inputName)
    {

        $uploadInfo = $_FILES[$inputName];

        if($this->exist($inputName)){

            $uploadDir = trim($this->config['save_dir'], '/');

            $this->info['name']   = $uploadInfo['name'];
            $this->info['size']   = $uploadInfo['size'];
            $this->info['suffix'] = pathinfo($uploadInfo['name'], PATHINFO_EXTENSION);

            if(!in_array($this->info['suffix'], explode('|', $this->config['allow_suffix']))){

                $this->error = '文件类型不允许上传';
                return false;

            }

            $uploadMaxFileSize = ini_get('upload_max_filesize');
            $postMaxFileSize   = ini_get('post_max_size');

            if($this->info['size'] >= $uploadMaxFileSize * 1024 * 1024){

                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值！';
                return false;

            }

            if($this->info['size'] >= $postMaxFileSize * 1024 * 1024){

                $this->error = '上传的文件超过了 php.ini 中 post_max_size 选项限制的值！';
                return false;

            }

            if($this->info['size'] >= $this->config['max_size'] * 1024 * 1024){

                $this->error = '上传的文件超过了配置文件里限制的最大值！';
                return false;

            }

            if(!trim($uploadDir)){

                $this->error = '上传目录不存在';
                return false;

            }

            if(!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true)){

                $this->error = '上传目录创建失败';
                return false;

            }

            if($this->config['local']['save_name']){

                $saveName = $this->config['save_name'];

            }else{

                $saveName = date('YmdHis').uniqid();

            }

            $filePath = $uploadDir .'/'. $saveName . '.' . $this->info['suffix'];

            if ( ! move_uploaded_file($uploadInfo['tmp_name'], $filePath ) ) {

                $this->error = '移动临时文件失败';
                return false;

            }

            return '/'.$filePath;

        }else{

            $this->error = '没有上传文件';
            return false;

        }

    }

    // 获取错误信息
    public function getError()
    {
        return $this->error;
    }

    public function watermark($dst_path,$mark_file)
    {

        $src_path = $mark_file;
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
        //获取水印图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
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