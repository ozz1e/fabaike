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
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        halt($request->post());
        if( $request->isAjax() || $request->isPost() ){
            $data = $request->post();
            if( empty($data) ){
                return json(400,[],['data'=>['msg'=>'提交数据异常']]);
            }

        }else{
            return json(403,[],['data'=>['msg'=>'请求方式有误']]);
        }
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


}
