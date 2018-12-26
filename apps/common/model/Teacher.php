<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2018/10/24
 * Time: 17:13
 */
namespace app\common\model;

use think\Model;

class Teacher extends Model
{
    protected $table = 'yunzhi_teacher';

    /**
     * 判断用户是否登录
     * @return bool 已登录true
     */
    public static function isLogin()
    {
        $teacherId = session('teacherId');

        if (isset($teacherId)) {
            return true;
        }
        return false;
    }

    /**
     *  用户登录
     * @param string $username
     * @param string $password
     * @return bool 登录成功true
     * @throws \think\exception\DbException
     */
    public static function login($username, $password)
    {
        // 验证用户名是否存在
        $map = array( 'username' => $username);

        $Teacher = self::get($map);

        if (!is_null($Teacher) && $Teacher->checkPassword($password)) {
            // 登录
            session('teacherId', $Teacher->getData('id'));
            return true;
        }
        return false;
    }

    /**注销
     * @return bool 注销成功true,失败false
     */
    public static function logOut()
    {
        // 销毁session中数据
        session('teacherId', null);
        return true;
    }

    /**
     * 验证密码是否正确
     * @param string $password
     * @return bool
     */
    public function checkPassword($password)
    {
        trace($this->getData('password') === $this::encryptPassword($password));
        return $this->getData('password') ===  $this::encryptPassword($password);
    }


    /**
     * @param string $password
     * @return string
     * 密码加密算法
     */
    public static function encryptPassword($password)
    {
        if (!is_string($password)) {
            throw new \RuntimeException('转入变量类型非字符串', 2);
        }
        return sha1(md5($password) . 'mengyunzhi');
    }
}