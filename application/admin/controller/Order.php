<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Order as OrderModel;

class Order extends Controller
{
    //权限控制
    protected $middleware = ['Login','Auth'];

    /**
     * 显示订单列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = OrderModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    public function search(Request $request)
    {
        $params = $request->only('product_name,customer_name,phone_number,status,__token__');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = OrderModel::searchItem($params );
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'param'=>$params,
            'message'=>isset($message)?$message:''
        ]);
    }


}
