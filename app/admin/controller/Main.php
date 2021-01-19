<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use think\Db;
use think\facade\View;
use app\admin\model\Menu;
use app\common\controller\AdminBase;

class Main extends AdminBase
{
  
    /**
     *  后台欢迎页
     */
    public function index()
    {
        return View::fetch('index');
    }

    public function dashboardWidget()
    {
        $dashboardWidgets = [];
        $widgets          = $this->request->param('widgets/a');
        if (!empty($widgets)) {
            foreach ($widgets as $widget) {
                if ($widget['is_system']) {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 1]);
                } else {
                    array_push($dashboardWidgets, ['name' => $widget['name'], 'is_system' => 0]);
                }
            }
        }

        cmf_set_option('admin_dashboard_widgets', $dashboardWidgets, true);

        $this->success('更新成功!');

    }

}
