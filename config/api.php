<?php
/**
 * Api测试配置
 * ======
 * @author 洪波
 * @version 19.05.21
 */
return [
    'version' => 1,
    //测试地址主域
    'domain' => 'http://p.cc/',
    //额外传输参数，在POST方法中有效
    'extra' => [
        'uid' => '',
        'token' => ''
    ],
    //API测试列表
    'list' => [
        0 => [
            //名称 - 可空
            'name' => '获取栏目列表',
            'path' => 'channel/getSimpleList',
            'method' => 'post',
            'data' => [
                'offset' => 0,
                'limit' => 1
            ]
        ],
    ]
];