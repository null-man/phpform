<?php

namespace Fy\Form;

use Fy\Common\BaseFactory;

/*
|--------------------------------------------------------------------------
| Form 工厂类
|--------------------------------------------------------------------------
|
| 对象化生成表单
| 
| @author anonymous <635384073@qq.com>
|
*/

class FormFactory extends BaseFactory
{
    // 类映射
    const TYPE_CLASS_MAP = [

        'text'      => 'Fy\Form\Type\Text',
        'hidden'    => 'Fy\Form\Type\Text',
        'password'  => 'Fy\Form\Type\Text',
        'radio'     => 'Fy\Form\Type\Checkbox',
        'checkbox'  => 'Fy\Form\Type\Checkbox',
        'select'    => 'Fy\Form\Type\Select',
        'textarea'  => 'Fy\Form\Type\Textarea',
        'date'      => 'Fy\Form\Type\Date'

    ];




    // 默认配置
    public $config = [

        'url'       => '',          // 表单url
        'method'    => 'POST',      // 表单请求方式
        'is_ajax'   => true,        // 是否ajax
        
        'nav_tabs'  => [
            [
                'class'=>'active',
                'name'=> '主页'
            ]
        ]

    ];





    public function __construct($config)
    {
        parent::__construct();

        /*
         * 组装配置
         */
        $this->config = array_merge($this->config, $config);

        // ### 初始化
        /*
         *  页面
         */
        $this->html = '<admintpl file="header" /></head><body><div class="wrap js-check-wrap">';

        /*
         * 标签
         */
        $this->navTabs($this->config['nav_tabs']);
        
        /*
         * 表单
         */
        $this->_formStart($this->config);
    }






    /**
     * 表单 配置
     * 
     * @param str $url 表单提交地址
     *
     * @param str $method 表单提交方式
     *
     * @param str $is_ajax 是否是ajax方式
     *
     *
     */
    private function _formStart($config)
    {
        $ajax_class = $config['is_ajax'] ? 'js-ajax-form' : '';
        $url        = $config['url'];
        $method     = $config['method'];

        $this->html .= "<form class='form-horizontal $ajax_class' action='$url' method='$method'><fieldset>";
    }







    /**
     * 添加一个字段
     * 
     * @param str $name 字段名
     *
     * @param array $extra      属性参数
     *              lab_name    显示名(下拉框、多选框、单选框)
     *              name        属性名
     *              value
     *              checked
     *              selected
     *              show_name   展示名
     *
     */
    public function add($name, $type, $extra)
    {
    	empty($name) && $this->exception('name is empty');
        empty($type) && $this->exception('type is empty');

        $class = self::TYPE_CLASS_MAP[$type];

        $this->html .= call_user_func_array("$class::setField", [$name, $type, $extra]);
    }







    /**
     * 生成表单
     *
     * @return str $this->html 带渲染的内容
     *
     */
    public function getForm()
    {
        $ajax_class  = $this->config['is_ajax'] ? 'js-ajax-submit' : '';
        $submit_name = $this->config['submit_name'] ?: '提交';

        $form_end = '</fieldset>'
                  . '<div class="form-actions">'
                  . "   <button type='submit' class='btn btn-primary $ajax_class'>$submit_name</button>"
                  . '   &nbsp;&nbsp;'
                  . '   <a class="btn" href="javascript:history.back(-1);">返回</a>'
                  . '</div></form></div>'
                  . '<script src="__PUBLIC__/js/common.js"></script>'
                  . '</body></html>';

        $this->show($this->html . $form_end);
    }




}