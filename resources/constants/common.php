<?php
// 有很多常量都可以统一，此处记录统一使用的常量
return [
    // 需要审核的审核状态
    'audit_status'     => [
        'unaudited' => [10, '未审核'],
        'failed'    => [80, '未通过'],
        'passed'    => [99, '已通过'],
    ],

    // 数据来源
    'source_from'      => [
        'insert'   => [10, '后台添加'],
        'register' => [20, '自行注册'],
        'woloong'  => [30, '卧龙注册'],
    ],

    // 证件类型
    'certificate_type' => [
        'id_card'           => ['10', '身份证'],
        'hk_and_macao_pass' => ['20', '港澳通行证'],
        'passport'          => ['30', '护照'],
        'other'             => ['40', '其他'],
    ],

    // 用工类型
    'employee_type'    => [
        'natural_person' => ['10', '灵活就业'],
        'self_employ'    => ['20', '个人独资'],
    ],

    // 性别
    'sex'              => [
        'male'    => ['1', '男'],
        'female'  => ['2', '女'],
        'unknown' => ['3', '未知'],
    ],
];