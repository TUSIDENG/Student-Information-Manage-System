<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2019/1/20
 * Time: 20:22
 */
namespace app\index\Controller;

use app\common\model\Student as StudentModel;
use think\Request;

class Student extends Index
{
    public function index()
    {
        $students = StudentModel::paginate();
        $this->assign('students', $students);
        return $this->fetch();
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
    /**
     * @TODO 新增
     * @TODO 删除
     */
}