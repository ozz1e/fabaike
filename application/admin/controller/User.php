<?php

namespace app\admin\controller;

use think\Request;
use think\facade\Session;
use app\admin\model\User as UserModel;

class User extends Base
{
    protected $middleware = [
        'Login' 	=> ['except' 	=> ['login','signin'] ],
        'Auth'
    ];

    /**
     * 用户列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list= UserModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 创建成员页面
     * @return mixed
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 保存新增用户
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('name,nick_name,phone_number,password');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = UserModel::createItem($params);
        return json($result);
    }

    /**
     * 搜索指定用户
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function search(Request $request)
    {
        $filter_content = $request->only('filter_content');
        if( !isset($filter_content) || empty($filter_content) ) return json(['code'=>0,'msg'=>'提交数据异常']);
        $result = UserModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'param'=>$filter_content['filter_content'],
            'message'=>isset($message)?$message:''
        ]);
    }

    /**
     * 重置密码页面
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function reset(Request $request)
    {
        $params = $request->only('id');
        if( !isset($params['id']) || empty($params['id']) || !is_numeric(intval($params['id'])) ) return json(['code'=>0,'msg'=>'提交数据异常']);
        return $this->fetch('reset',['id'=>$params['id']]);

    }

    /**
     * 重置密码
     * @param Request $request
     * @return \think\response\Json
     */
    public function resetpass(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('id,password');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = UserModel::resetItem($params);
        return json($result);
    }

    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'msg'=>'请求方式有误']);
        $params = $request->only('id');
        if( !isset($params) || empty($params) ) return json(['code'=>0,'msg'=>'提交数据异常']);

        $result = UserModel::deleteItem($params);
        return json($result);
    }

    /**
     * 后台登录页面
     * @return mixed
     */
    public function login()
    {
        if( Session::get('admin')) return $this->redirect(url('[admin.index]'));
        return $this->fetch();

    }

    /**
     * 进行登录操作
     * @param Request $request
     * @return \think\response\Json
     */
    public function signin(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ){
            return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        }
        $data = $request->post();
        if( !isset($data) || empty($data) ){
            return json(['code'=>0,'data'=>['msg'=>'提交数据异常']],403);
        }

        $result = UserModel::userLogin($data);
        return json($result);
    }

    /**
     * 账户退出
     */
    public function logout()
    {
        Session::delete('admin');
        $this->redirect(url('[user.login]'));
    }

}
