<?php

namespace app\admin\validate;

use think\Validate;

class Contract extends Validate
{

	protected $rule = [
	    'id'                    =>          'must|number',
	    'contract_name'         =>          'must|max:50',
        'download_times'        =>          'number'
    ];
    

    protected $message = [
        'id.must'                    =>          '合同id不能为空',
        'id.number'                     =>          '合同id必须为数字',
        'contract_name.must'         =>          '合同名称不能为空',
        'contract_name.length:2,50'     =>          '合同名称最大长度为50',
        'download_times.number'         =>          '下载次数必须为数字'
    ];

    protected $scene = [
        'create'    =>      ['contract_name','download_times'],
        'edit'      =>      ['id,contract_name','download_times'],
        'del'       =>      ['id'],
        'search'    =>      ['contract_name']
    ];
}
