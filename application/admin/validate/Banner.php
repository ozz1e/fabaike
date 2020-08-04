<?php

namespace app\admin\validate;

use think\Validate;

class Banner extends Validate
{

	protected $rule = [
	    'id'            =>          'require|number',
	    'url'           =>          'require|url',
        'is_index'      =>          'require|in:0,1',
        'sort'          =>          'number'
    ];
    

    protected $message = [
        'url.require'       =>      '跳转地址不能为空',
        'url.url'           =>      '跳转地址格式必须为url格式',
        'is_index.require'  =>      '设置首页选项不能为空',
        'is_index.in:0,1'   =>      '设置首页选项数据异常',
        'sort.number'       =>      '排序必须为数字'
    ];

    protected $scene = [
        'create'        =>      'url,is_index,sort',
        'del'           =>      'id',
        'update'        =>      'id,is_index',
    ];
}
