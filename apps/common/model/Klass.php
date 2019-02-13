<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/11
 * Time: 10:33
 */
namespace app\common\model;

use think\Model;

class Klass extends Model
{
    private $Teacher;

    /**
     * 获取对应的教师（辅导员）信息
     * @return Teacher
     */
    public function getTeacher()
    {
        if (is_null($this->Teacher)) {
            $teacherId = $this->getData('teacher_id');
            $this->Teacher = Teacher::get($teacherId);
        }
        return $this->Teacher;
    }

    /**
     * 班级和教师，多对一关联
     * @return \think\model\relation\HasOne
     */
    public function Teacher()
    {
        trace('执行一次');
        return $this->belongsTo('Teacher');
    }
}

