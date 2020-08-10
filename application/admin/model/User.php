<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use think\Db;
use think\facade\Session;
use app\admin\validate\User as UserValidate;

class User extends Model
{
    protected $name = 'admin';

    public function group()
    {
        return $this->hasOne('GroupAccess','uid','id');
    }

    /**
     *平台用户列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function showDataList()
    {
        $users = Db::view('admin','id,name,nick_name,phone_number,create_time')
                            ->view('auth_group_access','uid','admin.id=auth_group_access.uid','LEFT')
                            ->view('auth_group','title','auth_group.id=auth_group_access.group_id','LEFT')
                            ->select();
        return $users;

    }

    /**
     * 搜索指定用户
     * @param $params
     * @return array
     */
    public static function searchItem($params)
    {
        try{
            //搜索条件
            $map1 =  [['name','like','%'.$params['filter_content'].'%']];
            $map2 = [['nick_name','like','%'.$params['filter_content'].'%']];

            $result = Db::view('admin','id,name,nick_name,phone_number,create_time')
                ->view('auth_group_access','uid','admin.id=auth_group_access.uid','LEFT')
                ->view('auth_group','title','auth_group.id=auth_group_access.group_id','LEFT')
                ->whereOr([$map1,$map2])
                ->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];
    }

    /**
     * 新增平台用户
     * @param array $params 用户信息
     * @return array
     */
    public static function createItem($params)
    {
        $validate = new UserValidate();
        if( !$validate->batch(true)->scene('add')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $params['password'] = password_hash($params['password'],PASSWORD_DEFAULT);
            $params['create_time']  = time();
            $user = static::create($params);
            if( !$user ) return ['code'=>0,'msg'=>'新增用户失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$user->id,'msg'=>'新增用户成功']];
    }

    /**
     * 用户重置密码
     * @param $params
     * @return array
     */
    public static function resetItem($params)
    {
        $validate = new UserValidate();
        if( !$validate->batch(true)->scene('reset')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

         try{
            $user = static::get($params['id']);
            if( !$user ) return ['code'=>0,'msg'=>'没有找到需要重置密码的用户'];
            $params['password'] = password_hash($params['password'],PASSWORD_DEFAULT);
            $user->password = $params['password'];
            if( !$user->save() ) return ['code'=>0,'msg'=>'重置密码失败'];
         }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
         }
         return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'重置密码成功']];
    }

    public static function deleteItem($params)
    {
        $validate = new UserValidate();
        if( !$validate->batch(true)->scene('del')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($params['id'],'group');
            if( !$result ) return ['code'=>0,'msg'=>'没有找到要删除的用户'];
            if( !$result->together('group')->delete() ) return ['code'=>0,'msg'=>'用户删除失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$params['id'],'msg'=>'用户删除成功']];

    }

    /**
     * 管理员登录
     * @param $info
     * @return array
     */
    public static function userLogin($info)
    {
        $validate = new UserValidate();
        if( !$validate->batch(true)->scene('login')->check($info)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $user = static::where('name',$info['name'])->findOrEmpty();
            if( empty($user) ) return ['code'=>0,'msg'=>'登录用户不存在'];
            if( !password_verify($info['password'],$user->password)) return ['code'=>0,'msg'=>'用户名或密码不正确'];
            //登录成功后更新登录时间和ip
            $user->login_time = time();
            $user->login_ip = request()->ip();
            if( !$user->save() ) return ['code'=>0,'msg'=>'登录信息保存失败'];
            unset($user->password);
            //登录成功后把管理员信息写入session
            Session::set('admin',$user);
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$user->id,'msg'=>'登录成功']];
    }

}
