<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/20
 * Time: 15:29
 */
namespace app\index\model;

use think\Model;

class Book extends Model
{
    //定义类型转换
    protected $type = [
        'publish_time' => 'timestamp:Y-m-d',
    ];

    //定义新增自动完成属性
    protected $insert = ['status' => 1];

    //定义关联方法
    public function user()
    {
        return $this->belongsTo('User');
    }
}