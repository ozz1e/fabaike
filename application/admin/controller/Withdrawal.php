<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Withdrawal as WithdrawalMdeol;

class Withdrawal extends Controller
{
    /**
     * 显示提现列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = WithdrawalMdeol::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    public function search(Request $request)
    {
        $filter_content = $request->only('phone_number');
        if( !isset($filter_content) || empty($filter_content) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = WithdrawalModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'param'=>$filter_content['phone_number'],
            'message'=>isset($message)?$message:''
        ]);
    }


}
