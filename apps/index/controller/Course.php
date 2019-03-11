<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/22
 * Time: 16:47
 */
namespace app\index\controller;

use app\common\model\Klass as KlassModel;
use app\common\model\Course as CourseModel;
use think\Request;

class Course extends Index
{
    public function index(Request $request)
    {
        $name = $request->get('name');

        $Course = new CourseModel();
        // 定制查询信息
        if (!empty($name)) {
            $Course->where('name', 'like', '%' . $name . '%');
        }

        $courses = $Course->paginate(null, false, [
            'query' => [
                'name' => $name
            ],
        ]);

        $this->assign('courses', $courses);
        return $this->fetch();
    }

    public function add()
    {
        //@todo 向tp5官方提意见，使能够使用关联模型
        $klasses = KlassModel::all();
        $this->assign('klasses', $klasses);
        return $this->fetch();
    }

    public function save(Request $request)
    {
        $Course = new CourseModel();

        $Course->name = $request->post('name');
        if (!$Course->validate()->save($Course->getData())) {
            $this->error('课程信息保存失败:' . $Course->getError());
        }

        $klassids = $request->post('klass_id/a');
        if (!is_null($klassids)) {
            //@TODO 多对多关联，中间表不能自动写入时间戳
            if(!$Course->Klasses()->saveAll($klassids)) {
                return $this->error('课程-班级信息保存有误：' . $Course->Klasses()->failException());
            }
        }
    }

    public function edit(Request $request)
    {
        $id = $request->param('id/d');
        if (is_null($Course = CourseModel::get($id))) {
            $this->error('系统为找到id为' . $id . '的记录');
        }

        $klasses = KlassModel::all();

        $this->assign('Course', $Course);
        $this->assign('klasses', $klasses);

        return $this->fetch();
    }

    public function update(Request $request)
    {
        // 获取当前课程
        $id = $request->post('id/d');
        if (is_null($Course = CourseModel::get($id))) {
            return $this->error('不存在ID为' . $id . '的记录');
        }

        // 更新课程
        $Course->name = $request->post('name');
        if (false === $Course->validate(true)->save($Course->getData())) {
            return $this->error('课程信息更新发生错误：' . $Course->getError());
        }

        // 删除原有信息
        // 定制查询条件
        $map = ['course_id' => $id];

        // 执行删除操作。由于可能存在成功删除0条记录，姑使用false来进行判断，而不能使用
        // if(!$KlassCoursees::where($map)->delete())
        // 我们认为删除0条记录也是成功
        if (false === $Course->KlassCourses()->where($map)->delete()) {
            return $this->error('删除班级课程关联信息发生错误' . $Course->KlassCourses()->failException());
        }

        // 增加新增数据，执行添加操作。
        $klassIds = $request->post('klass_id/a');
        if(!is_null($klassIds)) {
            if(!$Course->Klasses()->saveAll($klassIds)) {
                $this->error('班级-课程信息保存错误：' . $Course->Klasses()->getError()); //关联模型没有getError方法
            }
        }

        $this->success('更新成功', 'index');
    }

    public function delete(Request $request)
    {
        // 获取当前课程
        $id = $request->param('id/d');
        if (is_null($Course = CourseModel::get($id))) {
            return $this->error('不存在ID为' . $id . '的记录');
        }

        if ($Course->delete()) {
            $Course->Klasses()->detach();
            $this->success('课程' . $Course->name . '删除成功');

        } else {
            return $this->error('删除失败' . $Course->getError());
        }
    }
}