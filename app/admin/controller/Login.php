<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use think\facade\Db;
use think\facade\View;

use app\common\controller\RestBase;

class Login extends RestBase
{
    /**
     * 登录页面
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return View::fetch("index");
    }

    /**
     * 提交数据
     *
     * @return \think\Response
     */
    public function doLogin()
    {

        // $loginAllowed = session("__LOGIN_BY_COM_ADMIN_PW__");

        // if (empty($loginAllowed)) {
        //     $this->error('非法登录!', com_get_root() . '/');
        // }

        $captcha = $this->request->param('captcha');

        if (empty($captcha)) {
            $this->error(lang('CAPTCHA_REQUIRED'));
        }
        //验证码
        if (!com_captcha_check($captcha)) {
            $this->error(lang('CAPTCHA_NOT_RIGHT'));
        }

        $name = $this->request->param("username");
        if (empty($name)) {
            $this->error(lang('USERNAME_OR_EMAIL_EMPTY'));
        }
        $pass = $this->request->param("password");
        if (empty($pass)) {
            $this->error(lang('PASSWORD_REQUIRED'));
        }
        if (strpos($name, "@") > 0) {//邮箱登陆
            $where['user_email'] = $name;
        } else {
            $where['user_login'] = $name;
        }

        $result = Db::name('user')->where($where)->find();

        if (!empty($result) && $result['user_type'] == 1) {
            if (com_compare_password($pass, $result['user_pass'])) {
                $groups = Db::name('RoleUser')
                    ->alias("a")
                    ->join('Role b', 'a.role_id =b.id')
                    ->where(["user_id" => $result["id"], "status" => 1])
                    ->value("role_id");
                if ($result["id"] != 1 && (empty($groups) || empty($result['user_status']))) {
                    $this->error(lang('USE_DISABLED'));
                }
                //登入成功页面跳转
                session('ADMIN_ID', $result["id"]);
                session('name', $result["user_login"]);
                $result['last_login_ip']   = get_client_ip(0, true);
                $result['last_login_time'] = time();
                $token                     = cmf_generate_user_token($result["id"], 'web');
                if (!empty($token)) {
                    session('token', $token);
                }
                Db::name('user')->update($result);
                cookie("admin_username", $name, 3600 * 24 * 30);
                session("__LOGIN_BY_CMF_ADMIN_PW__", null);

                $this->success(lang('LOGIN_SUCCESS'), (string)url("admin/Index/index"));
            } else {
                $this->error(lang('PASSWORD_NOT_RIGHT'));
            }
        } else {
            $this->error(lang('USERNAME_NOT_EXIST'));
        }
    }

    public function hello($name)
    {

        return 'Hello,' . $name . '！This is '. $this->request->action();
    }
}
