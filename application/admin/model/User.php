<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use think\facade\Session;
use app\admin\validate\User as UserValidate;

class User extends Model
{
    protected $table = 'fbk_admin';

    public static function userLogin($info)
    {
        $validate = new UserValidate();
        if( !$validate->batch(true)->check($info)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $user = static::where('name',$info['name'])->findOrEmpty();
            if( empty($user) ) return ['code'=>0,'msg'=>'登录用户不存在'];
            if( password_verify($user->password,$info['password'])) return ['code'=>0,'msg'=>'密码不正确'];
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
