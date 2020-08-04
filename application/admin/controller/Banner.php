<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Banner as BannerModel;

class Banner extends Base
{
    /**
     * 显示banner列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = BannerModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示创建banner单页.
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
        //
    }

    /**
     * 保存更新的banner状态
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ){
            json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        }
        $data = $request->only('id,is_index');
        if( !isset($data) || empty($data) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = BannerModel::changStatus($data);
        if( $result['code'] == 1){
            return json(['code'=>1,'data'=>$result['data']],200);
        }else{
            return json(['code'=>0,'data'=>['msg'=>$result['msg']]],403);
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ){
            return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        }
        $id = $request->only('id');
        if( !isset($id) || empty($id) ){
            return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);
        }

        $result = BannerModel::delItem($id);
        if( $result['code'] == 0){
            return json(['code'=>0,'data'=>['msg'=>$result['msg']]],403);
        }
        return json(['code'=>1,'data'=>['msg'=>'删除成功']],200);

    }

    public function add(Request $request)
    {
        $params = $request->only('url,is_index');
        $pic = $request->file('file');
        if( !isset($params) || !isset($pic) ){
            return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);
        }

        $result = BannerModel::createItem($params,$pic);
        if( $result['code'] == 1){
            return json(['code'=>1,'data'=>$result['data']],200);
        }else{
            return json(['code'=>0,'data'=>['msg'=>$result['msg']]],403);
        }
    }
}
