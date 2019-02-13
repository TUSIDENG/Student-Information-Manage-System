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
        $Klass = new KlassModel();

        $teachers = TeacherModel::all();
        $this->assign('teachers', $teachers);

        // 设置默认值
        $Klass->id = 0;
        $Klass->name = '';
        $Klass->teacher_id = 0;
        $this->assign('Klass', $Klass);
        return $this->fetch('edit');
    }

    /**
     * 保存数据
     * @param Request $request
     */
    public function save()
    {
        $Klass = new KlassModel();

        if (!$this->saveKlass($Klass)) {
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

        $result = $this->saveKlass($Klass, true);
        if (false === $result) {
            return $this->error('更新错误' . $Klass->getError());
        } elseif (0 === $result) {
            return $this->error('没有更新信息');
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

    /**
     * 对课程数据进行保存或更新
     * @param KlassModel $Klass
     * @param bool $isUpdate
     * @return false|int
     */
    private function saveKlass(KlassModel $Klass, $isUpdate = false)
    {
        if (!$isUpdate) {
            $Klass->name = input('post.name');
        }
        $Klass->teacher_id = input('post.teacher_id/d');

        return $Klass->validate()->save($Klass->getData());
    }
}