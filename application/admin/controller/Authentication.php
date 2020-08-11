<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Authentication as AuthenticationModel;
use think\Request;

class Authentication extends Controller
{
    //权限控制
    protected $middleware = ['Login','Auth'];

    /**
     * 显示实名认证列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = AuthenticationModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 搜索指定内容
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function search(Request $request)
    {
        $params = $request->only('phone_number,real_name,identity_card,status,__token__');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthenticationModel::searchItem($params);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'params'=>$params,
            'message'=>isset($message)?$message:''
        ]);
    }

    public function manage(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'提交方式有误']);
        $params = $request->only('id,status');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthenticationModel::manageItem($params);
        return json($result);

    }
}
