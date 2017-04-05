<?php

namespace Fy\ListMan\ListType;

/*
|--------------------------------------------------------------------------
| List - 函数解析数据
|--------------------------------------------------------------------------
|
| 把 数据 当作 参数, 从instance的函数解析
| 
| @author anonymous <635384073@qq.com>
|
*/

class Func
{
    public static function processingData($instance, $method, $data)
    {
    	if (!method_exists($instance, $method)) {
    		throw new \Exception(get_class($instance) . ":" . $method . " 方法不存在! ");
    	}

    	$ret = call_user_func_array([$instance, $method], [$data]);

    	return ['ret' => $ret];
    }

}