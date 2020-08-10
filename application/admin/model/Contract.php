<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Contract as ContractValidate;

class Contract extends Model
{
    protected $autoWriteTimestamp = true;

    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:m:i',$value);
    }

    public function getFileNameAttr($value)
    {
        $arr = explode(DIRECTORY_SEPARATOR,$value);
        return $arr[count($arr)-1];
    }

    /**
     * 显示合同列表
     * @param int $page 每页显示条数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function showDatalist($page = 6)
    {
        $pagiante = static::paginate($page);
        return $pagiante;
    }

    /**
     * 创建合同
     * @param $params 合同参数
     * @param $file   合同文件
     * @return array
     */
    public static function createItem($params,$file)
    {
        $validate = new ContractValidate();
        if( !$validate->batch(true)->scene('create')->check($params) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        $info = $file->move('../public/uploads/');
        $params['file_name'] = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$info->getSaveName();

        try{
            $result = static::create($params);
            if( !$result ) return ['code'=>0,'msg'=>'合同上传失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'合同上传成功']];
    }

    /**
     * 取出需要编辑的合同信息
     * @param $id   合同id
     * @return array
     */
    public static function editItem($id)
    {
        if( !is_numeric($id) ) return ['code'=>0,'msg'=>'合同id必须为数字'];
        try{
            $result = static::get($id);
            if( !$result ) return ['code'=>0,'msg'=>'未找到相应的合同'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];

    }

    /**
     * 更新合同信息
     * @param $data array 合同的信息
     * @return array
     */
    public static function updateItem($data)
    {
        $validate = new ContractValidate();
        if( !$validate->batch(true)->scene('edit')->check($data) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::get($data['id']);
            if( !$result ) return ['code'=>0,'msg'=>'没有找到相应的合同信息'];
            if( !$result->save($data) ) return ['code'=>0,'msg'=>'编辑失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$data['id'],'msg'=>'编辑成功']];
    }

    /**
     * 删除合同
     * @param $id  合同id
     * @return array
     */
    public static function deleteItem($id)
    {
        $validate = new ContractValidate();
        if( !$validate->batch(true)->scene('del')->check($id) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            //判断是否存在记录
            $result = static::get($id);
            if( !$result ) return ['code'=>0,'msg'=>'没有相关的信息'];
            //1.删除数据库中的记录
            if( !$result->delete() ) return ['code'=>0,'msg'=>'合同删除失败'];
            //2.删除储存的合同文件
            $filepath = env('ROOT_PATH').'public'.$result->getData('file_name');
            if( is_file($filepath) ) unlink($filepath);
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$id,'msg'=>'合同删除成功']];
    }

    /**
     * 筛选合同
     * @param $content 合同名称
     * @return array
     */
    public static function searchItem($content)
    {
        $validate = new ContractValidate();
        if( !$validate->batch(true)->scene('search')->check($content) ){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        try{
            $result = static::where('contract_name','like','%'.$content['contract_name'].'%')->paginate(6);
            $result_array = $result->toArray();
            if( !$result_array['data'] ) return ['code'=>0,'msg'=>'没有找到对应的内容'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>$result];

    }
}
