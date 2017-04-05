<?php

namespace Fy\Form\Type;

/*
|--------------------------------------------------------------------------
| Form表单 Select
|--------------------------------------------------------------------------
|
| 提供生产下拉框的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Select
{
    public static function setField($name, $type, $extra) {
        $show_name = $extra['show_name'] ?: $name;

        $add = '<div class="control-group">'
              . "   <label class='control-label'>$show_name</label>"
              . '   <div class="controls">'
              . "       <select name='$name'>";

        foreach ($extra['data'] as $key => $option) {
            $value      = $option['value'];
            $selected   = $option['selected'];
            $lab_name   = $option['lab_name'];

            $add .= "<option value='$value'";

            !empty($selected) && $add .= "selected='$selected'";

            $add .= "/>$lab_name</option>";
        }
        
        $add .= '</select></div></div>';

        return $add;
    }

}