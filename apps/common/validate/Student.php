<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/22
 * Time: 11:21
 */
namespace app\common\validate;

use think\Validate;

class Student extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,25',
        'num' => 'require|unique:student|length:10',
        'sex' => 'in:0,1',
        'klass_id' => 'require',
        'email' => 'unique:student|email'
    ];
}