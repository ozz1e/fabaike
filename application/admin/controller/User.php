<?php

namespace app\admin\controller;

use think\Request;
use think\facade\Session;
use app\admin\model\User as UserModel;

class User extends Base
{
    protected $middleware = [
        'Login' 	=> ['except' 	=> ['login','signin'] ],
    ];

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
        if( $result['code'] == 1 ){
            return json(['code'=>1,'data'=>$result['data']],200);
        }else{
            return json(['code'=>0,'data'=>['msg'=>$result['msg']]],403);
        }
    }

    public function logout()
    {
        Session::delete('admin');
        $this->redirect(url('[user.login]'));
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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

    public function test()
    {
        halt(\think\facade\Session::get('admin'));
    }


}
