<?php

namespace Fy\ListMan\FormType;

/*
|--------------------------------------------------------------------------
| List - Form表单 Select
|--------------------------------------------------------------------------
|
| 提供列表框架 中 表单生产下拉框的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Select
{
    public static function setField($name, $type, $extra) {
        $show_name = $extra['show_name'] ?: $name;

        $add = "$show_name : "
             . '<select name="serverid">';

        foreach ($extra['data'] as $key => $option) {
            $value      = $option['value'];
            $selected   = $option['selected'];
            $lab_name   = $option['lab_name'];

            $add .= "<option value='$value'";

            !empty($selected) && $add .= "selected='$selected'";

            $add .= "/>$lab_name</option>";
        }
        
        $add .= '</select>&nbsp;&nbsp;&nbsp;&nbsp;';

        return $add;
    }

}