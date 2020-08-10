<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{

	protected $rule = [
	    'id'                    =>              'must|number',
	    'name'              =>              'must|chsDash|length:3,50',
        'nick_name'     =>              'must|chsDash|length:2,50',
        'password'          =>              'must|max:255',
        'phone_number'      =>      'must|length:11,14',
    ];
    

    protected $message = [
        'id.must'               =>          'id不能为空',
        'id.number'         =>              'id只能为数字',
        'name.must'          =>          '用户名不能为空',
        'name.chsDash'          =>          '用户名不能为特殊字符',
        'name.length:3,50'      =>          '用户名太短或超出最大长度',
        'nick_name.chsDash'          =>          '昵称不能为特殊字符',
        'nick_name.length:3,50'      =>          '昵称太短或超出最大长度',
        'password.must'      =>          '密码不能为空',
        'password.max'          =>          '密码超过最大长度',
        'phone_number.must'     =>      '手机号码不能为空',
        'phone_number.length:11,14'     =>  '手机号码长度不规范'
    ];

    protected $scene = [
        'login'         =>          ['name','password'],
        'add'           =>          ['name','nick_name','phone_number','password'],
        'reset'         =>          ['id','password'],
        'del'           =>          ['id'],
    ];
}
