<?php

namespace app\admin\validate;

use think\Validate;

class Auth extends Validate
{
	protected $rule = [
	    'id'                =>              'must|number',
        'title'             =>              'must|max:20',
        'name'          =>              'must|max:80',
        'condition'     =>          'max:100',
        'status'        =>              'in:0,1'
    ];
    

    protected $message = [
        'id.must'               =>              '规则id不能为空',
        'id.number'         =>              '规则id只能为数字',
        'title.must'            =>              '规则名称不能为空',
        'title.max'             =>              '规则名称最大长度为50',
        'name.must'         =>              '规则地址不能为空',
        'name.max'          =>              '规则地址最大长度为80',
        'condition.max'     =>              '条件最大长度为100',
        'status.in:0,1'           =>            '状态值不符合规范'
    ];

    protected $scene = [
        'create'        =>          ['name','title','condition','status'],
        'update'        =>          ['id','name','title','condition','status'],
        'edit'              =>          ['id'],
        'del'               =>          ['id']
    ];
}
