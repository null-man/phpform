<?php

namespace Fy\Form;

use Fy\Form\FormFactory;

/*
|--------------------------------------------------------------------------
| Form 表单类
|--------------------------------------------------------------------------
|
| 对象化生成表单,依赖Form工厂类
| 
| @author anonymous <635384073@qq.com>
|
*/

class Form
{
    
    public static $instance = null;

    function __construct($config)
    {
        if (is_null(self::$instance)) {
            self::$instance = new FormFactory($config);
        }
    }


    /*
     * 添加字段
     */
    public function add($name, $type, $param = [])
    {
    	self::$instance->add($name, $type, $param);

    	return $this;
    }



    /*
     * 生产表单
     */
    public function getForm()
    {
    	return self::$instance->getForm();
    }

}
