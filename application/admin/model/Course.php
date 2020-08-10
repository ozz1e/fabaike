<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Course as CourseValidate;

class Course extends Model
{
    protected $autoWriteTimestamp = true;

    public function getStatusAttr($value)
    {
        $status = [1=>'正常',0=>'已下架'];
        return $status[$value];
    }

    public function getFileNameAttr($value)
    {
        $arr = explode(DIRECTORY_SEPARATOR,$value);
        return $arr[count($arr)-1];
    }

    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:m:i',$value);
    }

    /**
     * 显示课程列表
     * @param int $page 每页显示的条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDataList($page = 6)
    {
        $paginate = static::paginate($page);
        return $paginate;
    }

    /**
     * 创建课程
     * @param $params 课程参数
     * @param $video_path   视频储存地址
     * @return array
     */
    public static function createItem($params,$video_path)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('create')->check($params) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            //默认上传文件都是上架状态
            $params['status'] = 1;
            //视频存储地址
            $params['file_name'] = \think\facade\Cache::get('video_path');

            $result = static::create($params);
            if( !$result ) return ['code'=>0,'msg'=>'课程创建失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'课程创建成功']];
    }

    /**
     * 取出编辑的课程
     * @param $id
     * @return array
     */
    public static function editItem($id)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('edit')->check($id) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($id);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];

    }

    /**
     * 更新课程信息
     * @param $data     课程信息
     * @return array
     */
    public static function updateItem($data)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('update')->check($data) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($data['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找打到对应的内容'];
            if( !static::update($data)) return ['code'=>0,'msg'=>'课程编辑失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$data['id'],'msg'=>'课程编辑成功']];
    }

    /**
     * 下架课程
     * @param $id  课程id
     * @return array
     */
    public static function offItem($id)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('offsale')->check($id) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($id);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
            $result->status = 0;
            if( !$result->save() ) return ['code'=>0,'msg'=>'下架操作失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$id,'msg'=>'下架操作成功']];
    }

    /**
     * 删除课程
     * @param $id int 课程id
     * @return array
     */
    public static function deleteItem($id)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('del')->check($id) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($id);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到对应的数据'];

            //1.先删除数据库中记录
            if( !$result->delete() ) return ['code'=>0,'msg'=>'课程删除失败'];
            //2.删除储存的课程视频文件
            $filepath = env('ROOT_PATH').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$result->getData('file_name');
            if( is_file($filepath) )   unlink($filepath);

        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$id,'msg'=>'课程删除成功']];
    }

    /**
     * 筛选课程
     * @param $content 课程名称
     * @return array
     */
    public static function searchItem($content)
    {
        $validate = new CourseValidate();
        if( !$validate->batch(true)->scene('search')->check($content) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::where('title','like','%'.$content['title'].'%')->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];

    }
}
