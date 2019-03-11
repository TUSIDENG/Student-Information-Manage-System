<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/13
 * Time: 21:26
 */
namespace app\index\controller;

use think\Request;
use think\Exception\HttpResponseException;
use app\common\model\Teacher as TeacherModel;

/**
 * Class Teacher
 * @package app\index\controller
 * 教师管理
 */
class Teacher extends Index
{
    /**
     * 首页展示
     * @param Request $request
     * @return mixed|string
     */
    public function index(Request $request)
    {
        // 获取查询信息
        $name = $request->get('name');
        trace($name);

        $Teacher = new TeacherModel();
        // 定制查询信息
        if (!empty($name)) {
            $Teacher->where('name', 'like', '%' . $name . '%');
        }

        // 按条件查询数据，并调用分页
        $teachers = $Teacher->paginate(null, false, [
            'query' => [
                    'name' => $name,
            ],
        ]);
        // 向V层传数据
        $this->assign('teachers', $teachers);
        // 取回打包后的数据并输出
        return $this->fetch();
    }

    /**
     * 新增数据视图
     */
    public function add()
    {
        // 实例化
        $Teacher = new TeacherModel();
        // 设置默认值
        $Teacher->id = 0;
        $Teacher->name = '';
        $Teacher->username = '';
        $Teacher->sex = 0;
        $Teacher->email = '';

        $this->assign('Teacher', $Teacher);
        return $this->fetch('edit');
    }

    /**
     * 插入新数据
     * @param Request $request
     * @return string html
     */
    public function save()
    {
        try {
            // 实例化Teacher对象
            $Teacher = new TeacherModel();
            // 反馈结果
            if (!$this->saveTeacher($Teacher)) {
               //验证未通过，发生错误
                $message = '新增失败' . $Teacher->getError();
            } else {
                //提示操作成功，并跳转至教师管理列表
                return $this->success('用户' . $Teacher->name . '新增成功。', url('index')); //成功跳转会返回ThinkPHP内置异常
            }
        } catch (HttpResponseException $e) {
            // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理。
            throw $e;

        } catch (\Exception $e) {
            // 发生异常
            return $e->getMessage();
        }

        return $this->error($message);

    }

    public function delete(Request $request)
    {
        try {
            $id = $request->param('id/d');

            if (is_null($id) || $id === 0) {
                throw new \Exception('未获取到ID信息', 1);
            }

            // 获取要删除的对象
            $Teacher = TeacherModel::get($id);

            // 要删除的对象不存在
            if (is_null($Teacher)) {
                throw new \Exception('不存在id为' . $id . '的教师');
            }

            // 删除对象
            if (!$Teacher->delete()) {
                return $this->error('删除失败：' . $Teacher->getError()); // 错误跳转会返回ThinkPHP内置异常
            }
        } catch (HttpResponseException $e) {
            // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
            throw $e;
        } catch (\Exception $e) {
            // 获取到正常的异常时，输出异常
            return $e->getMessage();
        }


        return $this->success('删除成功', $request->header('referer'));
    }

    /**
     * 编辑
     * @param Request $request
     * @return html
     * @throws \think\exception\DbException
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->param('id/d');

            // 判断是否成功接收
            if (is_null($id) || $id === 0) {
                throw new \Exception('未获取到ID信息', 1);
            }
            if (is_null($Teacher = TeacherModel::get($id))) {
                //由于在$this->error中抛出了异常，所以也可以省略return(不推荐）
                $this->error('系统未找到' . $id . '的记录');
            }

            $this->assign('Teacher', $Teacher);

            $html = $this->fetch();

            return $html;
        } catch (HttpResponseException $e) {
            // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
            throw $e;
        } catch (\Exception $e) {
            // 获取到正常的异常时，输出异常
            return $e->getMessage();
        }

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

            // 获取当前对象
            $Teacher = TeacherModel::get($id);

            if (is_null($Teacher)) {
                throw new \Exception('所更新的记录不存在', 1);
            }

            // 更新
            // TODO: 尝试更改库代码，用模型方式进行更新
            if (false === $this->saveTeacher($Teacher, true)) {
                return $this->error('更新失败' . $Teacher->getError());
            }
        } catch (HttpResponseException $e) {
            // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
            throw $e;
        } catch (\Exception $e) {
            // 由于对异常进行了处理，如果发生了错误，我们仍然需要查看具体的异常位置及信息，那么需要将以下的代码的注释去掉
            //throw $e;
            return $e->getMessage();
        }

        return $this->success('操作成功', url('index'));
    }

    /**
     * 对数据进行保存或更新
     * @param TeacherModel $Teacher
     * @return false|int
     */
    private function saveTeacher(TeacherModel $Teacher, $isUpdate = false)
    {
        // 写入要更新的数据
        $Teacher->name = input('post.name');
        if (!$isUpdate) {
            $Teacher->username = input('post.username');
        }
        $Teacher->sex = input('post.sex/d');
        $Teacher->email = input('post.email');

        // 更新或保存
        return $Teacher->validate(true)->save($Teacher->getData());
    }
}