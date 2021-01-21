<?php
declare (strict_types = 1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

// use app\common\controller\MyRedis;
use think\facade\Cache;

class Hello extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('hello')
            ->setDescription('the hello command');
    }

    protected function execute(Input $input, Output $output)
    {
        // $redis = new MyRedis();
        // $redis->setOption();

        // $redis->psubscribe(array('__keyevent@0__:expired'), function ($redis, $pattern, $chan, $msg){
        //     var_dump($redis,$pattern,$chan,$msg);
        // });

        // Cache::store('redis')->handler()->config('notify-keyspace-events','Ex');

        // Cache::store('redis')->psubscribe(array("__keyevent@0__:expired"),function(){
        //     var_dump(123);
        // });

        $this->getkey();
        $output->writeln("ok");

    }

    public function getkey(){
        // ini_set('default_socket_timeout', -1);
        //redis 订阅 第二个 是个 回调函数
        Cache::store('redis')->handler()->psubscribe(array('__keyevent@0__:expired'), 'app\command\Hello::keyCallback');//回调必须写绝对路径 要不然 会报错


    }
     public static function keyCallback($redis, $pattern, $channel, $message) {
        file_put_contents('order.log',$message."\r\n",FILE_APPEND);
        //随便写个 log 记录 不要复制  要不然会在项目的 根目录出现  记得写路径
        //在这里写逻辑啊 写数据库操作 
        
        echo '已删除订单编号:'.$message;
    }
}
