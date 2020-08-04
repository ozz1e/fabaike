<?php

namespace app\admin\validate;

use think\Validate;

class Customer extends Validate
{

	protected $rule = [
	    'customer_id'           =>          'require|number',
	    'wechat_name'           =>          'require',
        'phone_number'          =>          'require|length:11,14',
        'type'                  =>          'require|in:1,2,3',
        'account_balance'       =>          'number',
        'real_name'             =>          'chsDash',
        'identity_card'         =>          'require|length:18',
        'avatar'                =>          'image|fileSize:1024*1024*5',
        '__token__'             =>          'token'

    ];
    

    protected $message = [
        'wechat_name.require'               =>              '微信昵称不能为空',
        'phone_number.require'              =>              '手机号码不能为空',
        'phone_number.length:11,14'         =>              '手机号码长度有误',
        'type.require'                      =>              '类型不能为空',
        'type.in:1,2,3'                     =>              '类型有误',
        'account_balance.number'            =>              '余额只能为数字',
        'real_name.chsDash'                 =>              '真实姓名不能为特殊字符',
        'identity_card.require'             =>              '身份证号码不能为空',
        'identity_card.length:18'           =>              '身份证号码只能为18位'
    ];

    protected $scene = [
        'create'        =>      'wechat_name,phone_number,type,account_balance,real_name,identity_card,__token__',
        'edit'          =>      'customer_id'
    ];
}
