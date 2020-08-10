<?php

namespace app\admin\validate;

use think\Validate;

class Agent extends Validate
{

	protected $rule = [
	    'phone_number'      =>          'length:11,14',
        'inviter_phone_number'      =>          'length:11,14',
        '__token__'                     =>          'token'
    ];
    

    protected $message = [
        'phone_number.length:11,14'             =>          '手机号码长度不规范',
        'inviter_phone_number.length:11,14'             =>          '手机号码长度不规范',
    ];
}
