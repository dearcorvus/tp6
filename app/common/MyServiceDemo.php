<?php
namespace app\common;
class MyServiceDemo
{
    //定义一个静态成员变量
    protected static $myStaticVar = '123';
    // 设置该变量的值
    public static function setVar($value){
        self::$myStaticVar = $value;
    }
    //用于显示该变量
    public function showVar()
    {
        var_dump(self::$myStaticVar);
    }
}