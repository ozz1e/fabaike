<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Auth as AuthModel;

class Auth extends Base
{
    //权限控制
    protected $middleware = [
        'Login',
        'Auth'=>['except' 	=> ['notfound'] ]
];

    /**
     * 显示权限列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = AuthModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示创建权限规则单页.
     *
     * @return \think\Response
     */
    public function create()
    {
       return $this->fetch();
    }

    /**
     * 保存新建的规则
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('name,title,condition,status');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthModel::createItem($params);
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
     * 显示编辑权限单页.
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        $params = $request->only('id');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);
        $result = AuthModel::editItem($params);
        if( $result['code'] == 1 ){
            return $this->fetch('edit',['data'=>$result['data']]);
        }else{
            return $result['msg'];
        }

    }

    /**
     * 保存更新的资源
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('id,name,title,status,condition');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthModel::updateItem($params);
        return json($result);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('id');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);
        $result = AuthModel::deleteItem($params);
        return json($result);
    }

    public function notfound()
    {
        return $this->fetch('404');
    }
}
