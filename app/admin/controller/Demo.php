<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use think\facade\Db;
use think\facade\Cache;
use app\BaseController;
use app\common\MyServiceDemo;
// use app\common\controller\MyRedis;

use tree\TreeNode;

use app\admin\model\User;

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
        // $this->app->my_service->showVar();

        // Cache::stores('redis')->set();

        // $list = Db::name("user")->select([1,2]);

        // $list = User::select([1,2]);

        // foreach($list as $user){
            // 获取用户关联的profile模型数据
            // $user->profile;
        // }

        // $user = User::find(1);

        // 输出Profile关联模型的email属性
        // echo $user->profile->status;

        // $user = User::findOrEmpty(5);
        
        // $user = User::find(5);

        // var_dump($user);
        // echo "<pre>";
        // print_r($list);

        // $user = User::where('id', '1')->findOrEmpty();

        // if (!$user->isEmpty()) {
            // echo $user->user_pass;
        // }

        // 根据主键获取多个数据
        // $list = User::select([1,2,3]);
        // 对数据集进行遍历操作
        // foreach($list as $key=>$user){
            // echo "<br/>";
            // echo $user->user_login;
        // }

        // $this->redis->set('name411','lixuemin123111');
        
        // $this->redis->expire("name411",30);


        Cache::store('redis')->setex("wuya1","10","123");
        // echo Cache::store('redis')->get("wuya");
        // echo $this->redis->get('name411');
        // $this->redis->setex("wuya","20","123");
        // Cache::store('redis')->set('name','value1',30);
        // echo Cache::store('redis')->get('name');
        // Cache::store('redis')->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        // Cache::store('redis')->handler()->config('notify-keyspace-events','Ex');;
        // Cache::store('redis')->handler()->psubscribe(array("__keyevent@0__:expired"),'fredis');

            // $redis = new MyRedis();

            // $order_id = 123;
            // $redis->setex('order_id',10,$order_id);
            // echo $redis->get('order_id');
    }

    //入队
    public function enqueue()
    {
        $redis = $this->redis;
        
        $arr = array('c','c++','C#','java','go','python','PHP');
        foreach($arr as $k=>$v){
            $redis->rpush("myqueue",$v);
            echo $k."号入队成功"."<br/>";
            /*
             *  0号入队成功
             *  1号入队成功
             *  2号入队成功
             *  3号入队成功
             *  4号入队成功
             *  5号入队成功
             *  6号入队成功
             */ 
        }
    }

    //出队
    public function dequeue()
    { 
        $redis = $this->redis;
        $value = $redis->lpop('myqueue');
        if($value){
            echo "出队的值".$value;
        }else{
            echo "出队完成";
        }  
    }

    /**
     * 运行抓包
     * 
     */
    public function Capture()
    {
        $url = "https://www.baidu.com/";

        return    $this->curl_request($url);
    
    }

    /**
     * curl 抓包工具
     * 
     */
    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
    
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }

    /**
     * 两个站实现队列
     */
    public function queue()
    {
        $stack = [];

        // 获取 10 个随机数，压入栈
        for ($i=0; $i < 10; $i++) {
            $random  = rand(0,100);      // 随机数
            $stack[] = $random;          // 等同于 array_push($stack, $random);
        }

        print_r($stack);                 // 输出数组

        while (!empty($stacks)) {
            $pop = array_shift($stacks);  // 先入先出，弹出队列首
            echo "<br/>" . $pop;
        }
    }

    /**
     * tree
     */

    public function TreeFn()
    {
        $pre = [1,2,4,7,3,5,6,8];
        $vin = [4,7,2,1,5,3,8,6];

        return $this->reConstructBinaryTree($pre,$vin);
    }

    /**
     * 递归重建二叉树
     *
     * @param array $pre 前序遍历序列
     * @param array $vin 中序遍历序列
     */
    public function reConstructBinaryTree($pre, $vin)
    {
        // 递归要注意出口：如果没有前、中序遍历序列，那么就不要递归。
        if($pre && $vin) {
            $root  = new TreeNode($pre[0]);       // 根节点
            $index = array_search( $pre[0],$vin); // 根节点在中序数组的位置
            $root->left = $this->reConstructBinaryTree(array_slice($pre,1,$index),array_slice($vin,0,$index));
            $root->right = $this->reConstructBinaryTree(array_slice($pre,$index+1),array_slice($vin,$index+1));
            return $root;
        }

        return null;
    }


}
