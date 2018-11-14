<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/20
 * Time: 20:09
 */
namespace app\index\model;

use think\Model;

class Role extends Model
{
    protected $autoWriteTimestamp = false;
    public function user()
    {
        //角色 BELONGS_TO_MANY用户
        return $this->belongsToMany('Role', 'access');
    }
}