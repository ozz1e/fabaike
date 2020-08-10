<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Withdrawal as WithdrawalValidate;

class Withdrawal extends Model
{
    public function getWithdrawalTime($value)
    {
        return date('Y-m-d H:m:i',$value);
    }

    public function getStatusAttr($value)
    {
        $status = [0=>'未处理',1=>'已处理',2=>'已拒绝'];
        return $status[$value];
    }

    /**
     * 显示提现列表
     * @param int $page  每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 6)
    {
        $paginate = static::paginate($page);
        return $paginate;
    }

    public static function searchItem($params)
    {
        $validate = new WithdrawalValidate();
        if( !$validate->batch(true)->check($params) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        unset($params['__token__']);

        try{
            $result = static::where('phone_number',$params['phone_number'])->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }


}
