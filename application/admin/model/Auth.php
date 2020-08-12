<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Auth as AuthValidate;

class Auth extends Model
{
    protected $name = 'auth_rule';

    public function scopeStatus($query)
    {
        $query->where('status',1);
    }

    /**
     * 显示规则列表
     * @param int $page 每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 10)
    {
        $paginate = static::scope('status')->paginate($page);
        return $paginate;
    }

    /**
     * 创建权限规则
     * @param $params
     * @return array
     */
    public static function createItem($params)
    {
        $validate = new AuthValidate();
        if( !$validate->batch(true)->scene('create')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::create($params);
            if( !$result ) return ['code'=>0,'msg'=>'规则创建失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'规则创建成功']];
    }

    /**
     * 查询需要编辑的规则
     * @param $params
     * @return array
     */
    public static function editItem($params)
    {
        $validate = new AuthValidate();
        if( !$validate->batch(true)->scene('edit')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static ::get($params['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到需要编辑的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }

    /**
     * 更新编辑后的规则
     * @param array $params
     * @return array
     */
    public static function updateItem($params)
    {
        $validate = new AuthValidate();
        if( !$validate->batch(true)->scene('update')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($params['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到需要编辑的内容'];
            if( !$result->save($params) ) return ['code'=>0,'msg'=>'规则编辑失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'规则编辑成功']];
    }

    /**
     * 删除规则
     * @param $params
     * @return array
     */
    public static function deleteItem($params)
    {
        $validate = new AuthValidate();
        if( !$validate->batch(true)->scene('del')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static ::get($params['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到需要删除的规则'];
            if( !$result->delete() ) return ['code'=>0,'msg'=>'规则删除失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'规则删除成功']];

    }
}
