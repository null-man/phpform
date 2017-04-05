<?php

namespace Fy\ListMan;

use Fy\Common\BaseFactory;

/*
|--------------------------------------------------------------------------
| ListMan 工厂类
|--------------------------------------------------------------------------
|
| 对象化生成表格数据
| 
| @author anonymous <635384073@qq.com>
|
*/

class ListManFactory extends BaseFactory
{

    // 表单类映射
    const FORM_TYPE_CLASS_MAP = [
        'text'      => 'Fy\ListMan\FormType\Text',
        'hidden'    => 'Fy\ListMan\FormType\Text',
        'select'    => 'Fy\ListMan\FormType\Select',
        'date'      => 'Fy\ListMan\FormType\Date'
    ];


    // 表格类映射
    const LIST_TYPE_CLASS_MAP = [
        'func'      => 'Fy\ListMan\ListType\Func',
        'array'     => 'Fy\ListMan\ListType\Arr',
        'date'      => 'Fy\ListMan\ListType\Date',
        'html'      => 'Fy\ListMan\ListType\Html',
        'handle'    => 'Fy\ListMan\ListType\Handle'
    ];




    // 默认配置
    public $config = [

        'url'       => '',          // 表单url
        'method'    => 'POST',      // 表单请求方式
        
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
         * 脚本
         */
        $this->js = '<script type="text/javascript">';
    }

    





    /**
     * 表单 配置
     * 
     * @param str $url 表单提交地址
     * @param str $method 表单提交方式
     *
     *
     */
    public function formStart()
    {
        $url        = $this->config['url'];
        $method     = $this->config['method'];

        $this->html .= "<form class='well form-search' action='$url' method='$method'>";
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

        $class = self::FORM_TYPE_CLASS_MAP[$type];

        $this->html .= call_user_func_array("$class::setField", [$name, $type, $extra]);
    }







    /**
     * 生成表单
     *
     * @return str $this->html 带渲染的内容
     *
     */
    public function formEnd()
    {
        $submit_name = $this->config['submit_name'] ?: '提交';
        $url         = $this->config['url'];

        $form_end = "<input type='submit' class='btn btn-primary' value='$submit_name' />"
                  . "&nbsp;&nbsp;<a class='btn btn-danger' href='$url'>清空</a></form>";
    
        $this->html .= $form_end;
    }







    /**
     * 渲染数据
     * 
     * @param instance $instance 对象实例 依赖注入
     * @param array $data 数据
     *
     */
    public function renderData($instance, $data)
    {
        $table = '<table class="table table-hover table-bordered"><thead><tr>';
        $model          = $data['model'];
        $renderdata     = $data['data'];
        $page           = $data['page'] ?: FALSE;

        // 渲染标题栏
        foreach ($model as $model_value) {
            $list_name = $model_value['list_name'];
            $table .= "<th>$list_name</th>";
        }

        $table .= '</tr></thead><tbody>';
        
        // 渲染数据
        if ($renderdata) {
            // 一个js方法渲染一次, 所以不加入遍历
            // 调用的是同一个js方法
            $js_config = [];

            foreach ($renderdata as $key => $data_value) {
                $table .= '<tr>';

                foreach ($data_value as $k => $v) {
                    $_v_data = $v;

                    $type = $model[$k]['type'];

                    if ($type) {
                        $method = $model[$k]['method'];
                        $class = self::LIST_TYPE_CLASS_MAP[$type];

                        // html 类型特殊处理
                        if ($type === 'html') {
                            $ret = call_user_func_array("$class::processingData", [$instance, $method, $v, $data_value, ['js_config' => $js_config]]);
                            
                            !empty($ret['js']) && $this->js .= $ret['js'];
                            
                            $js_config = $ret['js_config'];


                        } else {
                            $ret = call_user_func_array("$class::processingData", [$instance, $method, $v]);
                        }

                        $_v_data = $ret['ret'];
                    }

                    $table .= "<td>$_v_data</td>";
                
                }

                // 单行数据操作
                if (isset($model['handle'])) {
                    $key = $model['handle']['key'] ?: 'id';
                    $handle = $model['handle'];

                    $class = self::LIST_TYPE_CLASS_MAP['handle'];
                
                    $ret = call_user_func_array("$class::processingData", [$instance, $handle, $data_value[$key]]);

                    $_v_data = $ret['ret'];
                    $table .= "<td>$_v_data</td>";
                }

                $table .= '</tr>';
            }
        }

        $table .= '</tbody></table>';

        $page && $table .= "<div class='pagination'>$page</div>";

        $table .='</div>';
       
        $this->html .= $table;
    }








    /**
     * 生成List
     *
     * @return param
     *
     */
    public function getList()
    {
        $this->html .= '<script src="__PUBLIC__/js/common.js"></script></body>'
                    . $this->js 
                    . '</script>' 
                    .'</html>';

        $this->show($this->html);
    }





}