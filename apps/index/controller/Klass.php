<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/11
 * Time: 10:38
 */
namespace app\index\controller;

use app\common\model\Teacher as TeacherModel;
use app\common\model\Klass as KlassModel;
use think\Request;

class Klass extends Index
{
    public function index()
    {
        $klasses = KlassModel::paginate();
        $this->assign('klasses', $klasses);
        return $this->fetch();
    }

    public function add()
    {
        $teachers = TeacherModel::all();
        $this->assign('teachers', $teachers);
        return $this->fetch();
    }

    /**
     * 保存数据
     * @param Request $request
     */
    public function save(Request $request)
    {
        $Klass = new KlassModel();

        $Klass->name = $request->post('name');
        $Klass->teacher_id = $request->post('teacher_id/d');
        if (!$Klass->validate(true)->save($Klass->getData())) {
            return $this->error('数据添加错误：' . $Klass->getError());
        }
        return $this->success('数据添加成功', url('index'));
    }

    public function edit(Request $request)
    {
        $id = $request->param('id/d');

        $teachers = TeacherModel::all();
        $this->assign('teachers', $teachers);

        if (null === $Klass = KlassModel::get($id)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        $this->assign('Klass', $Klass);
        return $this->fetch();
    }

    public function update(Request $request)
    {
        $id = $request->post('id/d');

        $Klass = KlassModel::get($id);
        if (is_null($Klass)) {
            return $this->error('系统未找到ID为' . $id . '的记录');
        }

        $Klass->name = $request->post('name');
        $Klass->teacher_id = $request->post('teacher_id/d');

        if (!$Klass->validate()->save($Klass->getData())) {
            return $this->error('更新错误' . $Klass->getError());
        }

        return $this->success('更新成功', url('index'));
    }

    public function delete(Request $request)
    {
        $id = $request->param('id/d');
        if (is_null($id)) {
            $this->error('未获取到id信息');
        }

        $Klass = KlassModel::get($id);
        if (is_null($Klass)) {
            $this->error('不存在id为' . $id . '的班级');
        }

        if(!$Klass->delete()) {
            return $this->error('删除失败' . $Klass->getError());
        }
        return $this->success('删除成功', $request->header('referer'));
    }

}