<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use think\facade\db;
use think\facade\View;
use app\common\controller\AdminBase;

use app\admin\model\AdminMenu as AdminMenuModel;

class Index extends AdminBase
{

    public function initialize()
    {
        $adminSettings = cmf_get_option('admin_settings');
        if (empty($adminSettings['admin_password']) || $this->request->path() == $adminSettings['admin_password']) {
            $adminId = cmf_get_current_admin_id();
            if (empty($adminId)) {
                session("__LOGIN_BY_CMF_ADMIN_PW__", 1);//设置后台登录加密码
            }
        }

        parent::initialize();
    }

    /**
     * 后台首页
     */
    public function index()
    {
        $adminMenuModel = new AdminMenuModel();
        $menus          = cache('admin_menus_' . cmf_get_current_admin_id(), '', null, 'admin_menus');
        $menus ="";

        if (empty($menus)) {
            $menus = $adminMenuModel->menuTree();

            cache('admin_menus_' . cmf_get_current_admin_id(), $menus, null, 'admin_menus');
        }

        View::assign("menus", $menus);


        $result = Db::name('AdminMenu')->order(["app" => "ASC", "controller" => "ASC", "action" => "ASC"])->select();
        $menusTmp = array();
        foreach ($result as $item){
            //去掉/ _ 全部小写。作为索引。
            $indexTmp = $item['app'].$item['controller'].$item['action'];
            $indexTmp = preg_replace("/[\\/|_]/","",$indexTmp);
            $indexTmp = strtolower($indexTmp);
            $menusTmp[$indexTmp] = $item;
        }

        View::assign("menus_js_var",json_encode($menusTmp));

        return View::fetch('index');
    }
}
