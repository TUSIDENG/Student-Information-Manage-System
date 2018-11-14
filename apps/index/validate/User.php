<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/18
 * Time: 11:48
 */
namespace app\index\validate;

use think\Validate;

class User extends  Validate
{
    protected $rule = [
        ['nickname', 'require|min:5|token', '昵称必须|昵称不能短于5个字符'],
        ['email', 'require|checkMail:thinkphp.cn', '邮箱必须|邮箱格式错误'],
        ['birthday', 'dateFormat:Y-m-d', '生日格式错误'],
    ];

    protected function checkMail($value, $rule)
    {
        $result = preg_match('/^\w+([-+.]\w+)*@' . $rule . '$/', $value);
        if (!$result) {
            return '邮箱只能是' . $rule . '域名';
        }
        return true;
    }
}