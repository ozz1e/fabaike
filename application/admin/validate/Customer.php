<?php

namespace app\admin\validate;

use think\Validate;

class Customer extends Validate
{

	protected $rule = [
	    'customer_id'           =>          'must|number',
	    'wechat_name'           =>          'must|length:1,16',
        'phone_number'          =>          'must|length:11,14',
        'type'                  =>          'must|in:1,2,3',
        'account_balance'       =>          'number',
        'real_name'             =>          'chsDash',
        'identity_card'         =>          'must|length:18',
        '__token__'             =>          'token'

    ];
    

    protected $message = [
        'wechat_name.must'               =>              '微信昵称不能为空',
        'wechat_name.length:1,16'       =>              '微信昵称长度不规范',
        'phone_number.must'              =>              '手机号码不能为空',
        'phone_number.length:11,14'         =>              '手机号码长度有误',
        'type.must'                      =>              '类型不能为空',
        'type.in:1,2,3'                     =>              '类型有误',
        'account_balance.number'            =>              '余额只能为数字',
        'real_name.chsDash'                 =>              '真实姓名不能为特殊字符',
        'identity_card.must'             =>              '身份证号码不能为空',
        'identity_card.length:18'           =>              '身份证号码只能为18位'
    ];

    protected $scene = [
        'create'        =>      ['wechat_name','phone_number','type,account_balance','real_name','identity_card','type','__token__'],
        'edit'          =>      ['customer_id'],
        'search'        =>  ['__token__'],
    ];
}
