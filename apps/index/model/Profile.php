<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/19
 * Time: 23:33
 */
namespace app\index\model;

use think\Model;

class Profile extends Model
{
    //定义自动写入时间戳
    protected $autoWriteTimestamp = false;
    //protected $dateFormat = 'Y/m/d H:i:s';
    protected $type = [
        //设置birthday转换为日期时间戳类型
        'birthday' => 'timestamp:Y-m-d',
    ];
    //定义关联方法
    public function user()
    {
        return $this->belongsTo('User');
    }
}