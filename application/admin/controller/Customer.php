<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Customer as CustomerModel;

class Customer extends Controller
{
    /**
     * 显示客户列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $paginate = CustomerModel::showDataList();
        return $this->fetch('index',['data'=>$paginate]);
    }

    /**
     * 显示创建客户单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存新增的客户信息
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if( !$request->isPost() ) return json(403,[],['data'=>['msg'=>'请求方式有误']]);
        $info = $request->only('wechat_name,phone_number,account_balance,type,real_name,identity_card');
        $avatar = $request->file('file');

        if( empty($info) || empty($avatar) )  return json(['code'=>0,'data'=>['msg'=>'提交数据异常']]);

        $result = CustomerModel::createItem($info,$avatar);

        return json($result);
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
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    public function search(Request $request)
    {
        $filter_content = $request->only('wechat_name,phone_number,real_name,identity_card,type,__token__');
        if( !isset($filter_content ) || empty($filter_content ) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = CustomerModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'message'=>isset($message)?$message:'',
            'params'=>$filter_content
            ]);
    }


}
