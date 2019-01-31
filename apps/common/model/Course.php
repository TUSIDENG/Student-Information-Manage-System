<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/22
 * Time: 16:42
 */
namespace app\common\model;

use think\Model;

class Course extends Model
{
    /**
     * 多对多关联
     * @return \think\model\relation\BelongsToMany
     */
    public function Klasses()
    {
        return $this->belongsToMany('Klass', 'klass_course');
    }

    /**
     * 一对多关联
     * @return \think\model\relation\HasMany
     */
    public function KlassCourses()
    {
        return $this->hasMany('KlassCourse');
    }

    public function getIsChecked(Klass &$Klass)
    {
        // 取课程和班级id
        $courseId= (int) $this->id;
        $klassId = (int) $Klass->id;

        // 定制查询条件
        $map = array();
        $map['klass_id'] = $klassId;
        $map['course_id'] = $courseId;

        $KlassCourse = KlassCourse::get($map);

        if (is_null($KlassCourse)) {
            return false;
        } else {
            return true;
        }
    }
}