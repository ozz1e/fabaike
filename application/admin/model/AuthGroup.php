<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\AuthGroup as AuthGroupValdaite;

class AuthGroup extends Model
{
    /**
     * 显示角色列表
     * @param int $page 每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 6)
    {
        $paginate = static ::paginate($page);
        return $paginate;
    }

    /**
     * 创建角色
     * @param $params
     * @return array
     */
    public static function createItem($params)
    {
        $validate = new AuthGroupValdaite();
        if( !$validate->check($params) ) return ['code'=>0,'msg'=>$validate->getError()];

        try{
                $result = static::create(['title'=>$params['title']]);
                if( !$result ) return ['code'=>0,'msg'=>'新增角色失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'新增角色成功']];
    }

    /**
     * 搜索角色
     * @param $params
     * @return array
     */
    public static function searchItem($params)
    {
        $validate = new AuthGroupValdaite();
        if( !$validate->check($params) ) return ['code'=>0,'msg'=>$validate->getError()];

        try{
            $result = static::where('title','like','%'.$params['title'].'%')->field('title')->find();
            if( !$result ) return ['code'=>0,'msg'=>'没有找到对应的数据'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }

    public static function deleteItem($params)
    {
        if( !is_numeric($params['id']) ) return ['code'=>0,'msg'=>'提交数据异常'];

        try{
            $result = static::get($params['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到对应的数据'];
            if(  !$result->delete() ) return ['code'=>0,'msg'=>'角色删除失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'角色删除成功']];
    }
}
