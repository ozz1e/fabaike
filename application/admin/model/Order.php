<?php

namespace app\admin\model;

use think\Exception;
use think\Model;

class Order extends Model
{
    public function getPaymentTimeAttr($value)
    {
        return date('Y-m-d H:m:i',$value);
    }

    public function getStatusAttr($value)
    {
        $status = [0=>'未支付',1=>'支付成功',2=>'待支付'];
        return $status[$value];
    }

    /**
     * 显示订单列表
     * @param int $page 每页显示条数
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
        unset($params['__token__']);
        //搜索条件
        $map = [];
        foreach ($params as $key=>$item) {
            if( empty($item) ) unset($params[$key]);
            $map[] = [$key,'like',$item.'%'];
        }

        try{
            $result = static::where($map)->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }
}
