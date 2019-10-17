<?php
return [
    // 全部权限节点名称
    'all_name' => '__ALL__',

    'super_role_id'    => 1,
    'readonly_role_id' => 2,

    // 超级节点所属
    'super_node_group' => 0,

    // 管理公司
    'admin'            => [
        'web' => [
            // controller 命名空间
            'controller_prefix' => 'App\\Http\\Controllers\\AdminApi\\',
            // uri 前缀
            'uri_prefix'        => 'admin-api/',
            'name'              => '管理公司WEB',
            'type'              => 99,
        ],
    ],

    // 企业
    'enterprise'       => [
        'web' => [
            // controller 命名空间
            'controller_prefix' => 'App\\Http\\Controllers\\EnterpriseApi\\',
            // uri 前缀
            'uri_prefix'        => 'enterprise-api/',
            'name'              => '企业WEB',
            'type'              => 10,
        ],
    ],

    // 供应商
    'supplier'         => [
        'web' => [
            // controller 命名空间
            'controller_prefix' => 'App\\Http\\Controllers\\SupplierApi\\',
            // uri 前缀
            'uri_prefix'        => 'supplier-api/',
            'name'              => '供应商WEB',
            'type'              => 20,
        ],
    ],
];