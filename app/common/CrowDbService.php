<?php

declare (strict_types = 1);

namespace app\common;


class CrowDbService
{
    //静态变量
    protected static $redis;

    public function getList()
    {
        echo $this->redis;
    }
}
