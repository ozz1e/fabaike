<?php

namespace app\admin\model;

use think\Model;

class Auth extends Model
{
    protected $name = 'auth_rule';

    public function scopeStatus($query)
    {
        $query->where('status',1);
    }

    public static function showDataList($page = 10)
    {
        $paginate = static::scope('status')->paginate($page);
        return $paginate;
    }
}
