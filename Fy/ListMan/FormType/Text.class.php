<?php

namespace Fy\ListMan\Type;

/*
|--------------------------------------------------------------------------
| List - Form表单 Text
|--------------------------------------------------------------------------
|
| 提供列表框架 中 表单生产文本框的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Text
{
    public static function setField($name, $type, $extra)
    {
        $show_name = $extra['show_name'] ?: $name;

        $value = $extra['value'];

       	$add .= "$show_name : <input type='$type' name='$name' value='$value'/>&nbsp;&nbsp;&nbsp;&nbsp;";

        return $add;
    }

}
