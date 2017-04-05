<?php

namespace Fy\Form\Type;

/*
|--------------------------------------------------------------------------
| Form表单 Textarea
|--------------------------------------------------------------------------
|
| 提供生产文本域的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Textarea
{
    public static function setField($name, $type, $extra) {
        $show_name  = $extra['show_name'] ?: $name;
        $width      = $extra['width']     ?: '600';
        $height     = $extra['height']    ?: '200';
        $value      = $extra['value'];

        $add = '<div class="control-group">'
             . "    <label class='control-label'>$show_name</label>"
             . '    <div class="controls">'
             . "        <textarea name='$name' style='margin: 0px; width:" . $width . "px; height: " . $height . "px;'>$value</textarea>"
             . '    </div>'
             . '</div>';

       	return $add;
    }

}