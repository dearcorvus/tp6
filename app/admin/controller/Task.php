<?php
namespace app\admin\controller;

use think\Db;
use think\Request;
use think\facade\Log;
use app\common\controller\Redis as RedisCommon;

// 定时任务
class Task 
{
    // 测试
    public function cs(){
        try {
            $redis = new RedisCommon();
            $redis->setex('8120707022110881',10,1);
            Log::record('测试日志信息');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function orders_task()
    {
        $redis = new RedisCommon();
        // 解决Redis超时情况
        $redis->setOption();
        $redis->psubscribe(array('__keyevent@0__:expired'), function($redis, $pattern, $chan, $msg){
            Log::record('测试日志信息');
        });
    }
}
