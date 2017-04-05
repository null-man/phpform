<?php

namespace Fy\Form\Type;

/*
|--------------------------------------------------------------------------
| Form表单 Checkbox
|--------------------------------------------------------------------------
|
| 提供生产多选框的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Checkbox
{
    public static function setField($name, $type, $extra)
    {
        $show_name = $extra['show_name'] ?: $name;

        $add = '<div class="control-group">'
             . "    <label class='control-label'>$show_name</label>"
             . '    <div class="controls">';

        foreach ($extra['data'] as $key => $data) {
            $real_name  = $type != 'radio' ? $name . '[]' : $name ;
            $value      = $data['value'];
            $checked    = $data['checked'];
            $lab_name   = $data['lab_name'];

          	$add .= "<label class='$type inline'>"
          		   .  "   <input type='$type' name='$real_name' value='$value'";
            
            !empty($checked) && $add .= "checked='$checked'";

          	$add .= "/>$lab_name</label>";
        }
       	
       	$add .= '</div></div>';

       	return $add;
    }

}
