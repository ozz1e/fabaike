<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Customer extends Migrator
{

    public function change()
    {
//        $table = $this->table('customer',array('engine'=>'InnoDB'));
//        $table->addColumn('customer_id', 'int',array('limit' => 10,'default'=>'','comment'=>'客户id'))
//              ->addColumn('wechat_name','string',array('limit'=>16,'default'=>'','comment'=>'微信昵称'))
//              ->addColumn('avatar','string',array('limit'=>200,'default'=>'','comment'=>'头像'))
//              ->addColumn('phone_number','string',array('limit'=>14,'default'=>'','comment'=>'手机号码'))
//              ->addColumn('type','int',array('limit'=>1,'default'=>1,'comment'=>'1:普通；2：金牌私人法律顾问；3：王牌私人法律顾问'))
//              ->addColumn('account_balance','')
    }
}
