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

    public static function crateItem($data)
    {
        $validate = new CustomerValidate();
        if( !$validate->batch(true)->scene('create')->check($data)){
            return ['code'=>0,'msg'=>$validate->getError()];
        }
        try{
            //将上传头像文件迁移至upload文件夹
            $pic = request()->file('avatar');
            //存放头像的文件夹名称
            $dir_name = env('APP_PATH').'public'.'/uploads/'.date('Ymd');
            //若文件夹不存在则创建
            if( is_dir($dir_name)){
                mkdir(env($dir_name,0777));
            }
            $info = $pic->move( $dir_name);
            if( $info ){
                $data['avatar'] = $info->getSaveName();
            }
            $new_data = static::allowField(static::$allowinsert)->save($data);
            if( !$new_data ){
                return ['code'=>0,'msg'=>'客户创建失败'];
            }


        }catch (Exception $e){

        }
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
