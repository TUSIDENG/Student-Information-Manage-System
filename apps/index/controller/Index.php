<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/12/27
 * Time: 23:30
 */
namespace app\index\controller;

use think\Controller;
use app\common\model\Teacher as TeacherModel;
use think\Request;

class Index extends Controller
{
    /**
     * 验证用户登录
     * Index constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        if (!TeacherModel::isLogin()) {
            return $this->error('请先登录', url('Login/index'));
        }
    }
}