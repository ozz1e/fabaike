<?php

namespace app\admin\validate;

use think\Validate;

class Order extends Validate
{

	protected $rule = [
	    'order_number'          =>          'must|number|length:14',
        'phone_number'          =>          'must|length:11,14',
        'customer_name'         =>          'must|max:50',
        'product_name'          =>              'must|max:50',
        'payment_amount'    =>              'must|float',
        'payment_type'          =>              'must|max:10',
        'payment_time'          =>              'must|max:10',
        'period'                    =>              'must|max:10',
        'status'                    =>              'must|in:0,1,2'
    ];
    

    protected $message = [
        'order_number.must'                     =>         '订单号不能为空',
        'order_number.number'                =>         '订单号必须为数字',
        'order_number.length:14'             =>         '订单号最大长度为14',
        'customer_name.must'                    =>          '客户姓名不能为空',
        'customer_name.max'                     =>          '客户姓名最大长度为50',
        'phone_number.must'                     =>          '客户手机号不能为空',
        'phone_number.length:11,14'         =>          '客户手机号长度不规范',
        'product_name.must'                     =>              '商品名称不能为空',
        'product_name.max'                      =>              '商品名称最大长度为50',
        'payment_amount.must'               =>              '支付金额不能为空',
        'payment_amount.float'              =>                  '支付金额只能为数字',
    ];
}
