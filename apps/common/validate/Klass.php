<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/19
 * Time: 19:52
 */
namespace app\common\validate;
use think\Validate;

class Klass extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,25',
        'teacher_id' => 'require',
    ];
}