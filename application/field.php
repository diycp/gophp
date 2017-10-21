<?php

namespace app;

class field {

    /**
     * 根据模块id获取接口列表
     * @param $user_id
     */
    public static function find($field_id)
    {

        return db('field')->find($field_id);

    }

    /**
     * 获取字段类型列表
     * @param $type
     * @return mixed
     */
    public static function get_type_list($type)
    {

        $data['string'] = '字符串(string)';
        $data['json']   = '字符串(json)';
        $data['int']    = '整形(int)';
        $data['float']  = '浮点型(float)';
        $data['mixed']  = '任意(mixed)';
        $data['boolean']= '布尔型(boolean)';
        $data['array']  = '数组(array)';
        $data['object'] = '对象(object)';
        $data['null']   = '对象(null)';

        return $type ? $data[$type] : $data;

    }

    /**
     * 获取接口字段列表
     * @param $api_id //接口id
     * @param $method  //类型，1：请求字段2：响应字段
     * @return array
     */
    public static function get_field_list($api_id, $method)
    {

        $field_list = db('field')->where('api_id', '=', $api_id)->where('method', '=', $method)->orderBy('id asc')->findAll();

        if(!$field_list){
            return [];
        }

        return category::toLevel($field_list, '&nbsp;&nbsp;&nbsp;&nbsp;');

    }

    /**
     * 根据字段类型获取默认值
     * @param $type
     * @param $value
     * @return int|null|string
     */
    public static function get_random_value($type,$value)
    {

        $default_value = null;

        switch ($type) {

            case 'string':
                $default_value = $value.rand(1,100);
                break;

            case 'int':
                $default_value = rand(200,999);
                break;

            case 'float':
                $default_value = sprintf('%.2f', rand(100,10000)/100);
                break;

            case 'boolean':

                $default_value = rand(0,1) ? 'true' : 'false';

                break;

            case 'null':
                $default_value = null;
                break;
        }

        return $default_value;

    }

    public static function check_name($data, $field_id)
    {

        $field_id = isset($field_id) ? $field_id : 0;

        $result = db('field')->show(false)->where('api_id', '=', $data['api_id'])->where('name', '=', $data['name'])->where('method', '=', $data['method'])->where('id', 'not in', [$field_id])->find();

        if($result){

            return true;

        }else{

            return false;

        }

    }

}