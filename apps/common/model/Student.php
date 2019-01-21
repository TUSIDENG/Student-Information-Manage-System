<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/20
 * Time: 20:18
 */
namespace app\common\model;
use think\Model;

class Student extends Model
{
    protected $dateFormat =  'Y年m月d日 h:i:s';

    /**自定义类型转换
     * @var array
     */

    protected $type = [
        'create_time' => 'datetime'
    ];
    /**性别获取器
     * @param $value
     * @return mixed
     */
    public function getSexAttr($value)
    {
        $status = array('男', '女');
        $sex = $status[$value];

        if (isset($sex)) {
            return $sex;
        } else {
            return $status[0];
        }
    }

    public function Klass()
    {
        return $this->belongsTo('Klass');
    }
}