<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use app\BaseController;
use app\common\MyServiceDemo;


class Demo extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function testService(MyServiceDemo $demo)
    {
        // 因为在服务提供类app\service\MyService的boot方法中设置了$myStaticVar=‘456’\
        // 所以这里输出'456'
        $demo->showVar();
    }

    public function testServiceDi(){
        // 因为在服务提供类的register方法已经绑定了类标识到被服务类的映射
        // 所以这里可以使用容器类的实例来访问该标识，从而获取被服务类的实例
        // 这里也输出‘456’
        $this->app->my_service->showVar();
    }

}
