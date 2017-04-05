<?php

namespace Fy\ListMan\FormType;

/*
|--------------------------------------------------------------------------
| List - Form表单 Date
|--------------------------------------------------------------------------
|
| 提供列表框架 中 表单生产下日期控件的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Date
{
    public static function setField($name, $type, $extra)
    {
        $show_name  = $extra['show_name'] ?: $name;
        $value		= $extra['value'];

		$add = "$show_name : <input class='js-datetime' type='text' name='$name' value='$value'/>&nbsp;&nbsp;&nbsp;&nbsp;";

       	return $add;
    }

}
