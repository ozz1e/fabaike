<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Contract as ContractModel;
use think\response\Json;

class Contract extends Controller
{
    //权限控制
    protected $middleware = ['Login','Auth'];

    /**
     * 显示合同列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = ContractModel::showDatalist();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示创建合同单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        if( !isset($id) || empty($id) ) json(['code'=>0,'msg'=>'数据异常'],403);
        $result = ContractModel::editItem($id);
        return $this->fetch('edit',['data'=>$result['data']]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']]);
        $data = $request->only('id,contract_name,download_times');
        //$file = $request->file('file');
        if( empty($data) ) return json(['code'=>0,'data'=>['msg'=>'提交数据异常']]);

        $result = ContractModel::updateItem($data);
        return json($result);

    }

    /**
     * 删除指定合同
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $id = $request->only('id');
        if( !isset($id) || empty($id) ) return json(['code'=>0,'data'=>['msg'=>'提交数据异常']],403);

        $result = ContractModel::deleteItem($id);
        return json($result);
    }

    /**
     * 添加合同
     * @param Request $request
     * @return \think\response\Json
     */
    public function add(Request $request)
    {
        if( !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $params = $request->only('contract_name,download_times');
        $file = $request->file('file');
        if( empty($params) || !isset($file) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = ContractModel::createItem($params,$file);
        return json($result);

    }

    /**
     * 筛选指定的合同
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function search(Request $request)
    {
        $filter_content = $request->only('contract_name');
        if( !isset($filter_content) || empty($filter_content) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = ContractModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'param'=>$filter_content['contract_name'],
            'message'=>isset($message)?$message:''
        ]);

    }


}
