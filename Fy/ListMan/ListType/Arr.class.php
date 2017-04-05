<?php

namespace Fy\ListMan\ListType;

/*
|--------------------------------------------------------------------------
| List - 数组解析
|--------------------------------------------------------------------------
|
| 获取解析数组解析数据
| 支持 数组 以及 函数 解析 
| 
| @author anonymous <635384073@qq.com>
|
*/

class Arr
{
    public static function processingData($instance, $method, $data)
    {
    	$ret = $data;

    	if (method_exists($instance, $method)) {
    		$arr = call_user_func_array([$instance, $method], []);

    		$ret = $arr[$data];
    	} elseif (is_array($method)) {
    		$ret = $method[$data];
    	}

    	return ['ret' => $ret];
    }

}