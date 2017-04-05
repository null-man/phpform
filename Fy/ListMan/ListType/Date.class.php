<?php

namespace Fy\ListMan\ListType;

/*
|--------------------------------------------------------------------------
| List - 函数解析数据
|--------------------------------------------------------------------------
|
| 解析时间戳
| 支持 字符串 以及 函数
| 
| @author anonymous <635384073@qq.com>
|
*/

class Date
{
    public static function processingData($instance, $method, $data)
    {
    	$ret = $data;

    	if (method_exists($instance, $method)) {
    		$ret = call_user_func_array([$instance, $method], [$data]);
    	} elseif (is_string($method)) {
    		$ret = date($method, $data);
    	}

    	return ['ret' => $ret];
    }

}