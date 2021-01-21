<?php
namespace app\common\controller;

use think\cache\driver\Redis as RedisModel;

class Redis
{
    private $redis;
 
    public function __construct()
    {
        $this->redis = new RedisModel();
    }
 
    public function setex($key, $time, $val)
    {
        return $this->redis->setex($key, $time, $val);
    }
 
    public function set($key, $val)
    {
        return $this->redis->set($key, $val);
    }
 
    public function get($key)
    {
        return $this->redis->get($key);
    }
 
    public function expire($key = null, $time = 0)
    {
        return $this->redis->expire($key, $time);
    }
 
    public function psubscribe($patterns = array(), $callback)
    {
        $this->redis->psubscribe($patterns, $callback);
    }
 
    public function setOption()
    {
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
    }
 
}