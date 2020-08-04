<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{

	protected $rule = [
	    'name'              =>              'require|chsDash|length:3,50',
        'password'          =>              'require|max:255',
        '__token__'         =>              'token',
    ];
    

    protected $message = [
        'name.require'          =>          '用户名不能为空',
        'name.chsDash'          =>          '用户名不能为特殊字符',
        'name.length:3,50'      =>          '用户名太短或超出最大长度',
        'password.require'      =>          '密码不能为空',
        'password.max'          =>          '密码超过最大长度',
    ];
}
