<?php

namespace Fy\Common;

use Think\View;

/*
|--------------------------------------------------------------------------
| 基础 工厂类
|--------------------------------------------------------------------------
|
| 提供通用方法
| 
| @author anonymous <635384073@qq.com>
|
*/

class BaseFactory 
{
    // 视图实例
    protected static $view = null;


    /**
     * 初始化视图
     * @return object
     */
    protected function __construct()
    {
        if (is_null(self::$view)) {
            self::$view = new View();
        }

        return self::$view;
    }





    /**
     * 输出内容文本可以包括Html 并支持内容解析
     * @access protected
     * @param string $content 输出内容
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @param string $prefix 模板缓存前缀
     * @return mixed
     */
    protected function show($content, $charset='', $contentType='', $prefix='')
    {
        self::$view->display('', $charset ,$contentType, $content, $prefix);
    }







    /**
     * 设置URL标签
     * 
     * @param array $navs 所有tab
     *
     */
    protected function navTabs($tabs)
    {
        $nav = '<ul class="nav nav-tabs">';

        foreach ($tabs as $tab) {
            $class = $tab['class'] ?: '';
            $url   = $tab['url']   ?: '';
            $name  = $tab['name']  ?: '标签' . time();

            $nav .= "<li class='$class'><a href='$url'>$name</a></li>";
        }
        
        $nav .= '</ul>';
        
        $this->html .= $nav;
    }







    /**
     * 抛出异常
     * 
     * @param str $exception 异常原因
     *
     */
    public function exception($exception = '出现异常! ')
    {
        throw new \Exception(__FUNCTION__ . ": $exception");
    }


}