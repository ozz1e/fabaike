<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use think\Request;

class AuthGroup extends Controller
{
    //权限控制
    protected $middleware = ['Login','Auth'];

    /**
     * 显示角色列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = AuthGroupModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 保存新增角色
     * @param Request $request
     * @return array|\think\response\Json
     */
    public function save(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'提交方式有误']);
        $params = $request->only('title');
        if( !isset($params) |  empty($params) ) return ['code'=>0,'msg'=>'提交数据异常'];

        $result = AuthGroupModel::createItem($params);
        return json($result);
    }

    /**
     * 搜索指定内容
     * @param Request $request
     * @return array|mixed
     */
    public function search(Request $request)
    {
        $params = $request->only('title');
        if( !isset($params) || empty($params) ) return ['code'=>0,'msg'=>'提交数据异常'];

        $result = AuthGroupModel::searchItem($params);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'params'=>$params['title'],
            'message'=>isset($message)?$message:''
        ]);
    }

    /**
     * 删除权限
     * @param Request $request
     * @return \think\response\Json
     */
    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'提交方式有误']);
        $params = $request->only('id');
        $result = AuthGroupModel::deleteItem($params);
        return json($result);
    }

    /**
     * 分配权限页面
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function authorize(Request $request)
    {
        $params = $request->only('id,title');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthGroupModel::authorizeItem($params);
        if( $result['code'] == 1 ){
            return $this->fetch('authorize',[
                'id'            =>  $params['id'],
                'role_title'=>$params['title'],
                'list'=>$result['data']['authlist'],
                'had'=>$result['data']['$role_had_rules']
            ]);
        }else{
            return $result['msg'];
        }
    }

    public function grant(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('id,rules');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = AuthGroupModel::grantItem($params);
        return json($result);

    }
}
