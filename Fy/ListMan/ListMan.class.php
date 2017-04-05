<?php

namespace Fy\ListMan;

use Fy\ListMan\ListManFactory;

/*
|--------------------------------------------------------------------------
| List 列表类
|--------------------------------------------------------------------------
|
| 对象化生成对表格数据的处理,依赖List工厂类
| 
| @author anonymous <635384073@qq.com>
|
*/

class ListMan
{
    
    public static $instance = null;

    function __construct($config)
    {
        if (is_null(self::$instance)) {
            self::$instance = new ListManFactory($config);
        }
    }



    /**
     * 表单 配置
     */
    public function formStart()
    {
        self::$instance->formStart();

        return $this;
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
    public function formEnd()
    {
    	self::$instance->formEnd();

        return $this;
    }



    /**
     * 渲染数据
     */
    public function renderData($instance, $data)
    {
        self::$instance->renderData($instance, $data);

        return $this;
    }




     /**
     * 生成List
     *
     */
    public function getList()
    {
        return self::$instance->getList();
    }

}
