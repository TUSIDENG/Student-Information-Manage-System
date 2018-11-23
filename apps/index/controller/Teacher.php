<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/13
 * Time: 21:26
 */
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Exception\HttpResponseException;
use app\common\model\Teacher as TeacherModel;

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
        //提示信息
        $message = '';

        try {
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
            if (false === $result) {
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

    /**
     * 新增数据视图
     */
    public function add()
    {
        return $this->fetch();
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

            // 判断是否成功接收
            if (is_null($id) || $id === 0) {
                throw new \Exception('未获取到ID信息', 1);
            }

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
}