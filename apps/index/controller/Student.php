<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/20
 * Time: 20:22
 */
namespace app\index\Controller;

use app\common\model\Student as StudentModel;
use app\common\model\Klass as KlassModel;
use think\Request;

class Student extends Index
{
    public function index()
    {
        $students = StudentModel::paginate();
        $this->assign('students', $students);
        return $this->fetch();
    }

    public function add()
    {
        $Klasses = KlassModel::all();
        $this->assign('Klasses', $Klasses);
        return $this->fetch();
    }

    public function save(Request $request)
    {
        $Student = new StudentModel();

        $Student->name = $request->post('name');
        $Student->num = $request->post('num/d');
        $Student->sex = $request->post('sex');
        $Student->klass_id = $request->post('klass_id');
        $Student->email = $request->post('email');

        if (!$Student->validate()->save($Student->getData())) {
            $this->error('数据添加错误' . $Student->getError());
        }
        return $this->success('数据添加成功', url('index'));
    }


    public function edit(Request $request)
    {
        $id = $request->param('id/d');

        if (is_null($Student = StudentModel::get($id))) {
            $this->error('未找到ID为' . $id . '的记录');
        }

        $this->assign('Student', $Student);

        return $this->fetch();
    }


    public function delete(Request $request)
    {
        $id = $request->param('id/d');

        $Student = StudentModel::get($id);
        if (is_null($Student)) {
            $this->error('未找到ID为' . $id . '的记录');
        }

        if (!$Student->delete()) {
            $this->error('删除失败' , $Student->getError());
        }
        $this->success('删除成功', $request->header('referer'));
    }
    /**
     * @TODO 查询
     */
}