<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Agent as AgentModel;

class Agent extends Controller
{
    /**
     * 显示经纪人列表
     * @return \think\Response
     */
    public function index()
    {
        $list = AgentModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 筛选指定内容
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function search(Request $request)
    {
        $filter_content= $request->only('phone_number,inviter_phone_number,__token__');
        if( !isset($filter_content) || empty($filter_content) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AgentModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'params'=>$filter_content,
            'message'=>isset($message)?$message:''
        ]);
    }


}
