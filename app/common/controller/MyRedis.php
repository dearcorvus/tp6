<?php
 
 
namespace app\common\controller;
 
 
class MyRedis
{
    private $redis;
 
    public function __construct($host = '127.0.0.1', $port = 6379)
    {
        $this->redis = new \Redis();
        $this->redis->config('notify-keyspace-events','Ex');//开启redis key 过期通知(改过配置文件，但没成功)
        $this->redis->connect($host, $port,60);
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
 
    public function subscribe($patterns = array(), $callback)
    {
        $this->redis->subscribe($patterns, $callback);
    }
 
    public function setOption()
    {
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
    }
 
}