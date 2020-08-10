<?php

namespace app\admin\validate;

use think\Validate;

class AuthGroup extends Validate
{

	protected $rule = [
	    'title'             =>              'must|chsDash'
    ];
    

    protected $message = [
        'title.must'            =>          '角色名称不能为空',
        'title.chsDash'         =>      '角色名称不能包含特殊符号'
    ];
}
