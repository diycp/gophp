<?php

namespace gophp\helper;

use gophp\validate;

class dir
{

    // 判断目录是否存在
    public static function exists($path)
    {

        return is_dir($path);

    }

    // 创建目录
    public static function create($path, $chmod = 0775)
    {

        if(validate::hasChinese($path) || is_dir($path)){

            return false;
        }

        return mkdir($path, $chmod, true);

    }

    // 获取目录下所有文件或子目录
    public static function getAll($path, $extension = '', $showInvisibleFile = false)
    {

        $fileList  = [];

        if(!self::exists($path)) return false;

        $extension = strtolower(trim($extension, '.'));

        $handle = opendir($path);

        while(($file = readdir($handle)) !== false){

            if($file == "." || $file == "..") {

                continue;

            }

            if(is_file($path. DS .$file) && $extension && file::getInfo($path. DS .$file, 'extension') != $extension){

                continue;

            }

            if($showInvisibleFile === false && strpos(file::getInfo($path. DS .$file, 'base_name'), '.') !== false) {

                continue;

            }

            $fileList[] = iconv('gbk', 'utf-8', $file);

        }

        closedir($handle);

        // 按照自然排序
        natsort($fileList);

        return $fileList;

    }

    // 获取目录下所有文件
    public static function getFile($path, $extension = '', $showInvisibleFile = false)
    {

        $fileList  = [];

        if(!self::exists($path)) return false;

        $extension = strtolower(trim($extension, '.'));

        $handle = opendir($path);

        while(($file = readdir($handle)) !== false){

            if(!is_file($path. DS .$file)){

                continue;

            }

            if($extension && file::getInfo($path. DS .$file, 'extension') != $extension){

                continue;

            }

            if($showInvisibleFile === false && strpos(file::getInfo($path. DS .$file, 'base_name'), '.') !== false) {

                continue;

            }

            $fileList[] = iconv('gbk', 'utf-8', $file);

        }

        closedir($handle);

        // 按照自然排序
        natsort($fileList);

        return $fileList;

    }

    // 获取目录下所有子目录
    public static function getDir($path, $showInvisibleFile = false)
    {

        $dirList = [];

        if(!self::exists($path)) return false;

        $handle = opendir($path);

        while(($file = readdir($handle)) !== false){

            if(!is_dir($path. DS .$file)){

                continue;

            }

            if($file == "." || $file == "..") {

                continue;

            }

            if(!$showInvisibleFile && strpos($file, '.') !== false) {

                continue;

            }

            $dirList[] = iconv('gbk', 'utf-8', $file);

        }

        closedir($handle);

        // 按照自然排序
        natsort($dirList);

        return $dirList;

    }

    // 删除目录下所有文件
    public static function deleteFile($path, $extension = '')
    {

        if(!self::exists($path)) return false;

        $handle = opendir($path);

        while(($file = readdir($handle)) !== false){

            if($file == "." || $file == "..") {

                continue;

            }

            if(is_file($path. DS .$file) && is_writable($path. DS .$file)){

                unlink($path. DS .$file);

            }

        }

        closedir($handle);

    }

    // 删除目录下所有子目录
    public static function deleteDir($path, $self = false)
    {

        if(!self::exists($path)) return false;

        $handle = opendir($path);

        while(($file = readdir($handle)) !== false){

            if($file == "." || $file == "..") {

                continue;

            }

            if(is_dir($path. DS .$file)) {

                self::deleteDir($path. DS .$file, true);

                rmdir($path. DS .$file);

            }elseif(is_file($path. DS .$file)) {

                unlink($path. DS .$file);

            }

            if($self === true){

                rmdir($path);

            }

        }

        closedir($handle);

    }

}