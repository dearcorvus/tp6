<?php
declare (strict_types = 1);

namespace app\service;
use my\util\FileSystem;

class FileSystemService extends \think\Service
{
    /**
     * 注册服务
     *
     * @return mixed
     */
    public function register()
    {
        //
        $this->app->bind('file_system',FileSystem::class);
    }

    /**
     * 直接绑定
     *
    *public $bind = [
    *   'file_system' => FileSystem::class
    *];
    */

    /**
     * 执行服务
     *
     * @return mixed
     */
    public function boot()
    {
        //
    }
}
