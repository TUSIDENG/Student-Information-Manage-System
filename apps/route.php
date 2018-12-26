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
    '[user]' => [
        'index' => 'index/user/index',
        'create' => 'index/user/create',
        'add' => 'user/add',
        'update/:id' => 'user/update',
        'delete/:id' => 'user/delete',
        'addList' => ['user/addList', ['method' => 'get']],
        '[:id]' => ['user/read', ['method' => 'get'], ['id' => '\d+']],
        'addBook' => 'user/addBook',
        'readBook' => 'user/readBook',
        'updateBook/:id' => 'user/updateBook',
        'deleteBook/:id' => 'user/deleteBook',
        //多对多关联操作
        'addRole' => 'user/addRole',
        'deleteRole' => 'user/deleteRole',
        'readRole' => 'user/readRole',
        'login' =>'login/index',
        'upload' => 'upload/index'
    ],

    'login' => 'index/login/login',
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