<?php

namespace Fy\ListMan\ListType;

/*
|--------------------------------------------------------------------------
| List - 额外处理数据
|--------------------------------------------------------------------------
|
| 添加额外内容 
| 支持 数组 以及 函数 解析 
| 
| @author anonymous <635384073@qq.com>
|
*/

class Html
{
    public static function processingData($instance, $method, $data, $data_value, $extra = [])
    {
    	$ret = $data;
        $js  = '';
        $js_config = $extra['js_config'];
        $uid = $extra['uid'];


    	if (method_exists($instance, $method)) {
    		$ret = call_user_func_array([$instance, $method], [$data]);
    	} elseif (is_array($method)) {
            $_data = $method[$data];
            $ret = '';

            foreach ($_data as $k => $v) {
                $content = $v['content'];
                $type = $v['type'];

                switch ($type) {
                    case 'span':
                        $color = $v['color'] ?: '#000';

                        $ret .= "<span style='color:$color'>$content</span>&nbsp;&nbsp;";
                        break;
                    
                    case 'url':
                        $url = $v['url'];

                        $ret .= "<a href='$url'>$content</a>&nbsp;&nbsp;";
                        break;

                    case 'ajax':
                        $url = $v['url'];
                        $param = $v['param'];
                        $callback = $v['callback'];

                        // debug
                        //dump('ajax名称：' . $v['name']);
                        //dump('获取ajax配置:');
                        //dump($js_config[$v['name']]);

                        // ### 初始化每个ajax配置
                        // 锁和uid配置 限制只初始化一次
                        if (empty($js_config[$v['name']]['flag'])) {
                            // js脚本加锁
                            $js_config[$v['name']] = [
                                'flag' => 0,
                                'uid' => md5(uniqid())
                            ];

                            //dump('数据为空, 初始化  ... ');
                        }

                        $uid = $js_config[$v['name']]['uid'];

                        //dump('再次获取配置：');
                        //dump($js_config);


                        //### 组装a标签
                        // 组装参数
                        $str_param  = '';
                        $ajax_param = '';
                        $arr_param  = [];


                        foreach ($param as $pv) {
                           $str_param .= "'$data_value[$pv]', ";
                           $ajax_param .= "$pv:$pv, ";
                           array_push($arr_param, $pv);
                        }

                        $str_param  = substr($str_param, 0, -2);
                        $ajax_param = substr($ajax_param, 0, -2);
                        $key_param  = implode(", ", $arr_param);


                        // 生成a标签
                        $ret .= "<a href='javascript:void(0)' onclick=\"func$uid($str_param)\">$content</a>&nbsp;&nbsp;";

                        // ### 生成js函数
                        // 函数锁处理 
                        if ($js_config[$v['name']]['flag'] !== 0) {
                            //dump("数据已加锁 ...");
                            break;
                        }

                        $js .= "function func$uid($key_param){\$.post(\"$url\", {"
                            .  $ajax_param
                            .  '}, function (result) {alert(result);location.reload()})} ';
                        
                        $js_config[$v['name']]['flag'] = 1;


                        //dump("函数加锁, flag设置为1");
                        //dump($js_config);

                        //dump("加锁完成 ... ");

                    break;
                }
            }
    	}

    	return ['ret' => $ret, 'js' => $js, 'js_config' => $js_config];
    }

}