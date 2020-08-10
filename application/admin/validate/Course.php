<?php

namespace app\admin\validate;

use think\Validate;

class Course extends Validate
{

	protected $rule = [
	    'id'            =>          'must|number',
	    'title'         =>          'must|max:50',
        'intro'         =>          'length:2,100',
        'hits'          =>          'number',
        'price'         =>          'must|float',
        '__token__'     =>          'token',
    ];
    

    protected $message = [
        'id.must'                =>          '课程id不能为空',
        'id.number'                 =>          '课程id必须为数字',
        'title.must'             =>          '标题不能为空',
        'title.length:6,50'           =>          '标题最大长度为50',
        'intro.length:10,100'          =>          '简介长度2-100',
        'hits'                      =>          '播放数量必须为数字',
        'price.must'             =>          '价格不能为空',
        'price.float'               =>          '价格必须为数字'
    ];

    protected $scene = [
        'create'        =>          ['title','intro','hits','price','__token__' ],
        'edit'          =>          ['id' ],
        'update'        =>          ['id','title','intro','hits','price','__token__'],
        'del'           =>          ['id'],
        'offsale'       =>          ['id'],
        'search'        =>          ['title'],
    ];
}
