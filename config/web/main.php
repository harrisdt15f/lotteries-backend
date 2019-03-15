<?php

return [

    // 缓存
    'cache' => [
        'lottery'   => [
            'key'           => 'c_lottery_all',
            'expire_time'   => 0,
            'name'          => '游戏缓存'
        ],

        'method_config'   => [
            'key'           => 'c_method_config_all',
            'expire_time'   => 0,
            'name'          => '玩法配置缓存'
        ],

        'method_object'   => [
            'key'           => 'c_method_object_all',
            'expire_time'   => 0,
            'name'          => '玩法对象缓存'
        ],

        'common'    => [
            'key'           => 'c_common',
            'expire_time'   => 3600,
            'name'          => '常规缓存'
        ]
    ],


];
