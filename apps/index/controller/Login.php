<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/5/31
 * Time: 10:14
 */
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Teacher as TeacherModel;

//实现用户登录与注销
class Login extends Controller
{
    // 用户登录表单
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 用户登录方法
     * @param Request $request
     */
    public function login(Request $request)
    {
       $postData = $request->post();

       // 直接调用M层方法，进行登录
        if (TeacherModel::login($postData['username'], $postData['password'])) {
            return $this->success('登录成功', url('Teacher/index'));
        } else {
            return $this->error('用户名或密码错误', url('index'));
        }
    }

    public function logOut()
    {
        if (TeacherModel::logOut()) {
            return $this->success('logout success', url('index'));
        }
        return $this->error('logout error', url('index'));
    }
}