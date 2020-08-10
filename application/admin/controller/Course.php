<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Course as CourseModel;
use think\response\Json;

class Course extends Controller
{
    protected static $video_path = '';
    /**
     * 显示课程列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = CourseModel::showDataList();
        return $this->fetch('index',['list'=>$list]);
    }

    /**
     * 显示创建课程单页.
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
     * 显示编辑课程单页.
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        $id = $request->only('id');
        if( !isset($id) || empty($id) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = CourseModel::editItem($id);

        $data = $result['data']??'';

        return $this->fetch('edit',['data'=>$data]);
    }

    /**
     * 保存更新的课程信息
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function update(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $data = $request->only('id,title,intro,hits,price,status,__token__');
        if( !isset($data) || empty($data) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = CourseModel::updateItem($data);
        return json($result);

    }

    /**
     * 删除指定资源
     * @return \think\Response
     */
    public function delete(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $id = $request->only('id');
        if( !isset($id) || empty($id) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = CourseModel::deleteItem($id);
        return json($result);
    }

    /**
     * 上传课程视频
     * @param Request $request
     * @return \think\response\Json
     */
    public function addvideo(Request $request)
    {
        if( !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $video = $request->file('file');
        $info = $video->move('../public/uploads/');
        static::$video_path = DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$info->getSaveName();
        \think\facade\Cache::store('redis')->set('video_path',static::$video_path);
        return json();
    }

    /**
     * 添加课程信息
     * @param Request $request
     * @return \think\response\Json
     */
    public function add(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ){
            return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        }

        $params = $request->only('title,intro,hits,price');
        if( !isset($params) ){
            return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);
        }


        $result = CourseModel::createItem($params,static::$video_path);
       return json($result);
    }

    /**
     * 下架课程
     * @param Request $request
     * @return \think\response\Json
     */
    public function offsale(Request $request)
    {
        if( !$request->isAjax() || !$request->isPost() ) return json(['code'=>0,'data'=>['msg'=>'请求方式有误']],403);
        $id = $request->only('id');
        if( !isset($id) || empty($id) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = CourseModel::offItem($id);
       return json($result);
    }

    /**
     * 筛选指定的课程
     * @param Request $request
     * @return mixed|\think\response\Json
     */
    public function search(Request $request)
    {
        $filter_content = $request->only('title');
        if( !isset($filter_content) || empty($filter_content) ) return json(['code'=>0,'data'=>['msg'=>'提交数据有误']],403);

        $result = CourseModel::searchItem($filter_content);
        if( $result['code'] == 1){
            $data = $result['data'];
        }else{
            $data = '';
            $message = $result['msg'];
        }
        return $this->fetch('index',[
            'result'=>$data,
            'param'=>$filter_content['title'],
            'message'=>isset($message)?$message:''
        ]);

    }


}
