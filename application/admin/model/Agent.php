<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Agent as AgentValidate;

class Agent extends Model
{

    public function getInvitationTimeAttr($value)
    {
        return date('Y-m-d H:m:i');
    }

    /**
     * 经纪人列表
     * @param int $page  每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 6)
    {
        $paginate = static::paginate($page);
        return $paginate;
    }

    /**
     * 筛选指定内容
     * @param  array $params  查询的条件
     * @return array
     */
    public static function searchItem($params)
    {
        $validate = new AgentValidate();
        if( !$validate->batch(true)->check($params) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            unset($params['__token__']);
            //搜索条件
            $map = [];
            foreach ($params as $key=>$item) {
                if( empty($item)) unset($params[$key]);
                $map[] = [$key,'like',$item.'%'];
            }
            $result = static::where($map)->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }
}
