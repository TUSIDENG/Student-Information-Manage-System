<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/10/29
 * Time: 23:42
 */
namespace app\common\validate;

use think\Validate;

class Teacher extends Validate
{
    protected $rule = [
        'username' => 'require|unique:teacher|length:4,25',
        'name' => 'require|length:2,25',
        'sex' => 'in:0,1',
        'email' => 'require|email|unique:teacher',
    ];
}