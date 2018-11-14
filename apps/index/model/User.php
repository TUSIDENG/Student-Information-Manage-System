<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/8
 * Time: 20:02
 */
namespace app\index\model;

use think\Model;

class User extends Model
{
    //定义一对一关联
    public function profile()
    {
        return $this->hasOne('Profile');
    }

    //定义一对多关联
    public function books()
    {
        return $this->hasMany('Book');
    }

    //定义多对多关联
    public function roles()
    {
        return $this->belongsToMany('Role', 'access');
    }

    //定义自动写入类型
    protected $insert = ['status'];

    //status修改器
    protected function setStatusAttr($value, $data)
    {
        return '流年' == $data['nickname'] ? 1 : 2;
    }

    //status属性读取器
    protected function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }

    //user_status属性读取器
    protected function getUserStatusAttr($value, $data)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$data['status']];
    }

    //email查询
    public function scopeEmail($query)
    {
        $query->where('email', 'thinkphp@qq.com');
    }

    //全局查询范围
    protected static function base($query)
    {
        $query->where('status', 1);
    }
}
