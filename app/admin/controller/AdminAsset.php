<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;

use think\facade\Db;
use think\facade\View;
use app\common\controller\AdminBase;

class AdminAsset extends AdminBase
{
    /**
     * 资源管理列表
     *
     * @adminMenu(
     *     'name'   => '资源管理',
     *     'parent' => '',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => 'file',
     *     'remark' => '资源管理列表',
     *     'param'  => ''
     * )
     */
    public function index()
    {

        $result = Db::name('asset')
            ->alias('a')->join('user u', 'a.user_id = u.id')
            ->field('a.*,u.user_login,u.user_email,u.user_nickname')
            ->order('a.create_time', 'DESC')
            ->paginate(10);

        View::assign('assets', $result->items());
        View::assign('page', $result->render());
        return View::fetch("index");
    }

    /**
     * 删除文件
     * @adminMenu(
     *     'name'   => '删除文件',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '删除文件',
     *     'param'  => ''
     * )
     */
    public function delete()
    {
        $id            = $this->request->param('id');
        $file_filePath = Db::name('asset')->where('id', $id)->value('file_path');
        $file          = 'upload/' . $file_filePath;
        $res = true;
        if (file_exists($file)) {
            $res = unlink($file);
        }
        if ($res) {
            Db::name('asset')->where('id', $id)->delete();
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}
