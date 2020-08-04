<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Banner as BannerValidate;

class Banner extends Model
{
    /**
     * 获取banner列表
     * @param int $page 每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 5)
    {
        $paginate = static::paginate($page);
        return $paginate;
    }

    /**
     * 删除指定banner
     * @param $id bannerid
     * @return array
     */
    public static function delItem($id)
    {
        $validate = new BannerValidate();
        if( !$validate->batch(true)->scene('del')->check($id)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($id);
            //先把该记录的存储的图片删除
            $picpath = env('ROOT_PATH').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$result->pic;
            if( is_file($picpath) )   unlink($picpath);

            if( !$result->delete() )  return ['code'=>0,'msg'=>'删除失败'];

        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

        return ['code'=>1,'data'=>['id'=>$id,'msg'=>'删除成功']];
    }

    /**
     * 设置banner是否为首页显示
     * @param array $data [id,is_index]
     * @return array
     */
    public static function changStatus($data)
    {
        $validate = new BannerValidate();
        if( !$validate->batch(true)->scene('update')->check($data)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            //判断该banner是否存在
            $result = static::get($data['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有相关的数据'];
            $result->is_index = $data['is_index'];
            if( !$result->save() ) return ['code'=>0,'msg'=>'操作失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

        return ['code'=>1,'data'=>['id'=>$data['id'],'msg'=>'操作成功']];
    }

    public static function createItem($params,$pic)
    {
        $validate = new BannerValidate();
        if( !$validate->batch(true)->scene('create')->check($params)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }
        //图片存放路径
//        $path = env('ROOT_PATH').'public/uploads/'.date('Ymd');
//        if( !is_dir($path) ){
//            mkdir($path,0777,true);
//        }
        $info = $pic->move('../public/uploads/');
        $params['pic'] = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$info->getSaveName();

        try{
            $result = static::create($params);
            if( !$result ) return ['code'=>0,'msg'=>'banner创建失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'banner创建成功']];
    }
}
