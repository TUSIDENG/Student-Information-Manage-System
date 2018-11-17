<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/13
 * Time: 21:26
 */
namespace app\index\controller;

use think\Controller;
use app\common\model\Teacher as TeacherModel;
use think\Request;

/**
 * Class Teacher
 * @package app\index\controller
 * 教师管理
 */
class Teacher extends Controller
{
    public function index(Request $request)
    {
        $Teacher = new TeacherModel();
        $teachers = $Teacher->select();

        // 向V层传数据
        $this->assign('teachers', $teachers);

        // 取回V层数据
        $html = $this->fetch();

        //将数据返回给用户
        return $html;
    }

    /**
     * 插入新数据
     * @param Request $request
     * @return string html
     */
    public function insert(Request $request)
    {
        // 接收转入数据
        $data = $request->param();

        // 实例化Teacher对象
        $Teacher = new TeacherModel();

        // 为对象赋值
        $Teacher->name = $data['name'];
        $Teacher->username = $data['username'];
        $Teacher->sex = $data['sex'];
        $Teacher->email = $data['email'];

        $result = $Teacher->validate(true)->save($Teacher->getData());

        // 反馈结果
        if ($result) {
            return '新增成功。新增ID为：s' . $Teacher->id;
        } else {
            return $Teacher->getError();
        }
    }

    /**
     * 新增数据视图
     */
    public function add()
    {
        return $this->fetch();
    }

    public function delete(Request $request)
    {
        $id = $request->param('id/d');

        if (is_null($id) || $id === 0) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Teacher = TeacherModel::get($id);

        // 要删除的对象不存在
        if (is_null($Teacher)) {
            return $this->error('不存在id为' . $id . '的教师');
        }

        // 删除对象
        if (!$Teacher->delete()) {
            return $this->error('删除失败：' . $Teacher->getError());
        }

        return $this->success('删除成功', url('index'));
    }

    /**
     * 编辑
     * @param Request $request
     * @return html
     * @throws \think\exception\DbException
     */
    public function edit(Request $request)
    {
        $id = $request->param('id/d');

        if (is_null($Teacher = TeacherModel::get($id))) {
            return '系统未找到' . $id . '的记录';
        }

        $this->assign('Teacher', $Teacher);

        $html = $this->fetch();

        return $html;
    }

    /**
     * 利用M层进行数据更新
     * @param Request $request
     * @return string
     */
    public function update(Request $request)
    {
        try {
            // 接收数据，获取要更新的关键字信息
            $id = $request->post('id/d');
            $message = '更新成功';

            // 获取当前对象
            $Teacher = TeacherModel::get($id);

            if (is_null($Teacher)) {
                throw new \Exception('所更新的记录不存在', 1);
            }

            // 写入要更新的数据
            $Teacher->name = $request->post('name');
            $Teacher->username = $request->post('username');
            $Teacher->sex = $request->post('sex');
            $Teacher->email = $request->post('email');

            // 更新
            // TODO: 尝试更改库代码，用模型方式进行更新
            if (false === $Teacher->validate(true)->save($Teacher->getData())) {
                $message = '更新失败' . $Teacher->getError();
            }
        } catch (\Exception $e) {
            // 由于对异常进行了处理，如果发生了错误，我们仍然需要查看具体的异常位置及信息，那么需要将以下的代码的注释去掉
            //throw $e;
            $message = $e->getMessage();
        }


        return $message;
    }
}