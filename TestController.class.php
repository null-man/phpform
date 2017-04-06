<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 2017/2/28
 * Time: 16:49
 *
 * 测试
 */

namespace DHAdmin\Controller;
use Common\Controller\AdminbaseController;

class TestController extends AdminbaseController
{

    /*
     * Form 模块测试
     */
    public function edit()
    {
        $config = [
            'url' => U('Test/editPost'),
            'is_ajax' => false,

            'nav_tabs'=>[
                [
                    'name'=> '标签x'
                ],

                [
                    'name'=> '标签二', 
                    'class'=>'active'
                ]
            ]
        ];


        $this->createFormBuilder($config)
            ->add('xxx', 'text', [
                'value' => '文本框', 'show_name'=>'文本框'
            ])
            ->add('pass', 'password', [
                'value' => '密码', 'show_name'=>'密码'
            ])
            ->add('hid', 'hidden', [
                'value' => '老子是hidden'
            ])
            ->add('radio', 'radio', [
                'show_name'=>'单选框','data' => [
                    [
                        'value' => '1', 'checked'=>'checked', 'lab_name'=> '开启'
                    ], 

                    [
                        'value' => '0', 'lab_name'=>'关闭'
                    ]
                ]
            ])
            ->add('checkbox', 'checkbox', [
                'show_name'=>'多选框','data' =>[
                    [
                        'value' => 'zuqiu', 'checked'=>'checked', 'lab_name'=> '足球'
                    ],

                    [
                        'value' => 'lanqiu', 'checked'=>'checked', 'lab_name'=>'篮球'
                    ]
                ]
            ])
            ->add('select', 'select', [
                'show_name'=>'下拉框','data' =>[
                    [
                        'value' => 'zuqiu', 'selected'=>'selected', 'lab_name'=> '足球'
                    ],

                    [
                        'value' => 'lanqiu', 'lab_name'=>'篮球'
                    ]
                ]
            ])
            ->add('textarea', 'textarea', [
                'show_name' => '文本域', 'value' => 'xxxxx'
            ])
            ->add('date', 'date', [
                'show_name' => '日期', 'value' => '2017-03-21 10:12'
            ])
            ->getForm();
    }


    /*
     * Form 模块 post接收数据
     */
    public function editPost()
    {
        //dump(I('post.'));
        $this->error('error!');
    }






    /*
     * List 模块测试
     */
    public function index()
    {
        if (IS_GET) {
            $config = [
                'url' => U('Test/index'),

                'nav_tabs'=>[
                    [
                        'name'=> 'List'
                    ],

                    [
                        'name'=> '标签二', 
                        'class'=>'active'
                    ]
                ]
            ];


            // 分页 每页20
            $count = M('Feedback', 'dh_')->count();
            $page  = $this->page($count, 10);

            $configs = M('Feedback', 'dh_')->order('time desc')->limit($page->firstRow, $page->listRows)->select();

            $data = [                
                'model' => [
                    'account' => [
                        'list_name' => '账号',
                    ],

                    'id' => [
                        'list_name' => '消息id',
                    ],

                    'serverid' => [
                        'list_name' => '服务器id',
                        'type'      => 'func',
                        'method'    => 'getServerName'
                    ],

                    'qatype' => [
                        'list_name' => '问题类型',
                        'type'      => 'array',
                        'method'    => 'getQatype'
                        // 'method' => [
                        //     1 => '登录问题',
                        //     2 => '账号相关',
                        //     3 => '充值问题',
                        //     4 => '游戏功能相关问题',
                        //     5 => '其他问题与建议'
                        // ]
                    ],

                    'content' => [
                        'list_name' => '反馈内容',
                    ],

                    'replay' => [
                        'list_name' => '回复内容',
                    ],

                    'time' => [
                        'list_name' => '时间',
                        'type'      => 'date',
                        // 'method'    => 'Y-m-d H:i:s'
                        'method'    => 'getDate'
                    ],

                    'status' => [
                        'list_name' => '回复状态',
                        'type'      => 'html',
                        'method'    => [
                            '0' => [
                                [
                                    'type' => 'span',
                                    'color' => '#F00',
                                    'content' => '未回复'
                                ],
                                    
                                [
                                    'type' => 'url',
                                    'content' => '回复',
                                ],
                                
                                [
                                    'name' => 'xxx',
                                    'type' => 'ajax',
                                    'content' => '回复ajax',
                                    'url' => U('Test/ajaxTest'),
                                    'param' => [
                                        'id',
                                        'account'
                                    ]
                                ] 
                                
                            ],

                            '1' => [
                                [
                                    'type' => 'span',
                                    'content' => '已回复'
                                ],

                                [
                                    'name' => 'replay',
                                    'type' => 'ajax',
                                    'content' => '回复ajax2',
                                    'url' => U('Tets/ajaxTest2'),
                                    'param' => [
                                        'id',
                                        'account',
                                        'xxx'
                                    ]
                                ] 
                            ]
                        ]
                    ],

                    'handle' => [
                        'list_name' => '操作',
                        // 'style'     => '&nbsp;<span style="color:red">|</span>&nbsp;',
                        'method'    => [
                            [
                                'url' => U('Test/edit'),
                                'name' => '编辑'
                            ],

                            [
                                'url' => U('Test/del'),
                                'name' => '删除',
                                'is_ajax' => TRUE
                            ]
                        ]
                    ]

                ],

                'data' => $configs,

                'page' => $page->show('Admin')
            ];

            $this->createListBuilder($config)
                 ->formStart()
                 ->add('select', 'select', [
                    'show_name'=>'下拉框',
                    'data' => [
                        [
                            'value' => 'zuqiu', 'selected'=>'selected', 'lab_name'=> '足球'
                        ],

                        [
                            'value' => 'lanqiu', 'lab_name'=>'篮球'
                        ]
                    ]
                 ])
                 ->add('text', 'text', ['value' => 'xxx'])
                 ->add('date', 'date')
                 ->formEnd()
                 ->renderData($this, $data)
                 ->getList();
        }


        if (IS_POST) {
            $param = I('post.');

            dump($param);
        }
        
    }



    public function ajaxTest()
    {
        echo '成功';
    }











    // 获取服务器名称
    public function getServerName($id)
    {
        return $this->getSerNameById($id);
    }


    // 获取问题类型
    public function getQatype()
    {
        return [
            1 => '登录问题',
            2 => '账号相关',
            3 => '充值问题',
            4 => '游戏功能相关问题',
            5 => '其他问题与建议'
        ];
    }

    // 时间处理
    public function getDate($time)
    {
        return date("Y-m-d H:i", $time);
    }



}