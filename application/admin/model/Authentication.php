<?php

namespace app\admin\model;

use think\Exception;
use think\Model;

class Authentication extends Model
{
    public function getStatusAttr($value)
    {
        $status = [0=>'待处理',1=>'已处理',2=>'已拒绝'];
        return $status[$value];
    }

    public function getApplicationTimeAttr($value)
    {
        return date('Y-m-d H:m:i',$value);
    }

    public function getIdentityCardImgAttr($value)
    {
        return json_decode($value,true);
    }

    /**
     * 查询实名认证列表
     * @param int $page 每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 6)
    {
        $paginate = static::paginate($page);
        return $paginate;
    }

    /**
     * 搜索指定内容
     * @param $params
     * @return array
     */
    public static function searchItem($params)
    {
        unset($params['__token__']);
        //搜索条件
        $map = [];
        foreach ($params as $key=>$item) {
            if( empty($item) ) unset($params[$key]);
            $map[] = [$key,'like','%'.$item.'%'];
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

    public static function manageItem($params)
    {
        if( !is_numeric($params['id']) ) return ['code'=>0,'msg'=>'提交数据异常'];
        $arr = [1,2];
        if( !in_array($params['status'],$arr) )  return ['code'=>0,'msg'=>'提交数据异常'];

        try{
                $result = static::get($params['id']);
                if( !$result ) return ['code'=>0,'msg'=>'未找到对应的数据'];
                $result->status = $params['status'];
                if( !$result->save() ) return ['code'=>0,'msg'=>'操作失败'];
        }catch (Exception $e){
                return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'操作成功']];
    }
}
