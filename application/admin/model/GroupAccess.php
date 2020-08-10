<?php

namespace app\admin\model;

use think\Model;

class GroupAccess extends Model
{
    protected $table = 'fbk_auth_group_access';
    protected $pk = 'uid';
}
