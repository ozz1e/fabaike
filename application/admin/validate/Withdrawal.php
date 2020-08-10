<?php

namespace app\admin\validate;

use think\Validate;

class Withdrawal extends Validate
{
	protected $rule = [
	    'phone_number'              =>          'must|length:11,14',
        '__token__'                         =>          'token',
    ];

    protected $message = [
        'phone_number.must'          =>      '手机号码不能为空',
        'phone_number.length:11,14' =>      '手机号码长度不规范'
    ];
}
