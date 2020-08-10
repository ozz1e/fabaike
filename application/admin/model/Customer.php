<?php

namespace app\admin\model;

use think\Exception;
use think\Model;
use app\admin\validate\Customer as CustomerValidate;

class Customer extends Model
{
    /**
     * @var array 允许新增的字段
     */
    protected static $allowinsert = ['wechat_name','avatar','phone_number','type','account_balance','real_name','identity_card','regtime'];


    /**
     * 获取客户列表
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
     * @param $data
     * @return array
     */
    public static function createItem($info,$avatar)
    {
        $validate = new CustomerValidate();
        if( !$validate->batch(true)->scene('create')->check($info)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        $pic = $avatar->move('../public/uploads/');
        $info['avatar'] = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$pic->getSaveName();

        try{
            $info['regtime'] = time();
            $result = static::create($info);
            if( !$result ) return ['code'=>0,'msg'=>'客户创建失败'];
        }catch (Exception $e){
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
        return ['code'=>1,'data'=>['id'=>$result->id,'msg'=>'客户创建成功']];
    }

    /**
     * 搜索指定内容
     * @param  array $data
     * @return array
     */
    public static function searchItem($data)
    {
        $validate = new CustomerValidate();
        if( !$validate->batch(true)->scene('search')->check($data)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }

        unset($data['__token__']);
        //搜索条件
        $map = [];
        //删除搜索条件中为空的选项
        foreach ($data as $key=>$item){
            if( empty($item) ) unset($data[$key]);
            $map[] = [$key,'like','%'.$item."%"];
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

    /**
     * 修改客户类型的显示
     * @param $value
     * @return string
     */
    public function getTypeAttr($value)
    {
        $type = '';
        switch ($value){
            case "1":
                $type = "普通";
                break;
            case "2":
                $type = "金牌私人法律顾问";
                break;
            case "3":
                $type = "王牌私人法律顾问";
                break;
            default:
                $type = "其他";
                break;
        }
        return $type;
    }

    /**
     * 修改前端时间显示格式
     * @param $value
     * @return string
     */
    public function getRegTimeAttr($value)
    {
        return date('Y-m-d H:m:i',$value);
    }
}
