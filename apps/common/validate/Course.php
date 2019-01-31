<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/22
 * Time: 16:43
 */
namespace app\common\validate;

use think\Validate;

class Course extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,25'
    ];
}