<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class User extends Model
{
    //关联模型
    public function profile()
    {
        return $this->hasOne('Asset');
    }
}
