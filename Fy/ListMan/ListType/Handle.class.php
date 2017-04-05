<?php

namespace Fy\ListMan\ListType;

/*
|--------------------------------------------------------------------------
| List - 单行数据操作
|--------------------------------------------------------------------------
|
| 
| 
| @author anonymous <635384073@qq.com>
|
*/

class Handle
{
    public static function processingData($instance, $handle, $id)
    {
        $ret = '';
        $method = $handle['method'];
        $style  = $handle['style'] ?: '|&nbsp;';

    	if (method_exists($instance, $method)) {
            $arr = call_user_func_array([$instance, $method], []);
        } elseif (is_array($method)) {
            $arr = $method;
        }

        $count = 1;
        foreach ($arr as $ak => $av) {
            $ret .= "<a href=\"$av&id=$id\">$ak</a>";
            count($arr) > $count && $ret .= $style;
            $count ++;
        }

    	return ['ret' => $ret];
    }

}