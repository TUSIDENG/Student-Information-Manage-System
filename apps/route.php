<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+',
    ],
    // 定义登录控制器路由
    '' => ['Login/index', ['method'=>'get']],
    'login' => ['Login/login', ['method'=>'post']],
    'logout' => ['Login/logOut', ['method'=>'get']],
    /**
     * test模块
     */
    '[hello]'     => [
        ':id'   => ['test/index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['test/index/hello', ['method' => 'post']],
    ],

    'hello/[:name]/[:city]$' => 'test/index/hello',
    'hellos/[:name]' => function ($name) {
        return 'Hello, ' . $name . '!';
    },

    '[blog]' => [
        ':year/:month$' => ['test/blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],
        ':id$' => ['test/blog/get', ['method' => 'get'], ['id' => '\d+']],
        ':name$' => ['test/blog/read', ['method' => 'get'], ['name' => '\w+']],
    ],

    'up' => 'upload/up',
];