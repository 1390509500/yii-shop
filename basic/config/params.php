<?php

return [
    'adminEmail' => 'admin@example.com',
    'manage' => [
        'pageSize' => 10,
    ],
    'front_login' => [
        'key' => md5("MemberController_login"),
    ],
    'admin_login' => [
        'key' => md5('AdminController_login'),
    ],
    'qq_login' => [
        'memcacheKey' => md5('MemberController_qqLogin'),
    ],
    'defaultValue' => [
        'avatar' => 'admin/img/contact-img.png',
    ],
    'cover' => [
        'width' => 433,
        'height' => 325,
    ],
    'pic_big' => [
        'width' => 246,
        'height' => 186,
    ],
    'pic_mid' => [
        'width' => 73,
        'height' => 73,
    ],
    'pic_min' => [
        'width' => 67,
        'height' => 60,
    ],
    'express' => [
        1 => '中通快递',
        2 => '顺丰快递',
    ],
    'expressPrice' => [
        1 => 15,
        2 => 20,
    ],
];
