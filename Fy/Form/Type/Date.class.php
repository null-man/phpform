<?php

namespace Fy\Form\Type;

/*
|--------------------------------------------------------------------------
| Form表单 Date
|--------------------------------------------------------------------------
|
| 提供生产日期控件的方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class Date
{
    public static function setField($name, $type, $extra) {
        $show_name  = $extra['show_name'] ?: $name;
        $value		= $extra['value'];

        $add = '<div class="control-group">'
        	  .	"	<label class='control-label'>$show_name</label>"
        	  . '	<div class="controls">'
			  . "		<input class='js-datetime' type='text' name='$name' value='$value'/>"
			  . '	</div>'
			  . '</div>';

       	return $add;
    }

}
