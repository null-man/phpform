<?php

namespace Fy\Form\Type;

/*
|--------------------------------------------------------------------------
| Form表单 Text
|--------------------------------------------------------------------------
|
| 提供生产文本框的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Text
{
    public static function setField($name, $type, $extra) {
        $show_name = $extra['show_name'] ?: $name;

        $value = $extra['value'];

        if ($type != 'hidden') {
        	$add = '<div class="control-group">'
        		 . "	<label class='control-label'>$show_name</label>"
        		 . '	<div class="controls">';
        }

       	$add .= "<input type='$type' name='$name' value='$value'/>";

       	$type != 'hidden' && $add .= '</div></div>';

       	return $add;
    }

}
