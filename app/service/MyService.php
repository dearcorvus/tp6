<?php
declare (strict_types = 1);

namespace app\service;
use think\Service;
use app\common\MyServiceDemo;

class MyService extends Service
{
    /**
     * 注册服务
     *
     * @return mixed
     */
    public function register()
    {
        // 将绑定标识到对应的类
        $this->app->bind('my_service', MyServiceDemo::class);
    }

    /**
     * 执行服务
     *
     * @return mixed
     */
    public function boot()
    {
        // 将被服务类的一个静态成员设置为另一个值
        MyServiceDemo::setVar('456');
    }
}
