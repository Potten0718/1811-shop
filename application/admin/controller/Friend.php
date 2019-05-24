<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Friend extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=\app\admin\model\Friend::all();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
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
        //接收数据
        $data=$request->post();
        // dump($data);die;
        // 验证数据
        $validate=validate('Friend');
        if(!$validate->check($data)){
            $content=$validate->getError();
            echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
        }
        // //入库
        $res=model('Friend')->save($data);
        if($res){
            echo json_encode(['content'=>'添加成功','icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
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
    public function delete($friend_id)
    {
        $res=\app\admin\model\Friend::destroy($friend_id);
        if($res){
            $this->success('删除成功','friend/index');
        }else{
            $this->error('删除失败');
        }
    }

    //验证姓名唯一性
    public function checkOnly(){
        $friend_id=input('post.friend_id');
        $friend_name=input('post.friend_name');
        if(empty($friend_id)){
            $where[]=['friend_name','=',$friend_name];
        }else{
            $where[]=['friend_name','=',$friend_name];
        }
        $count=db('Friend')->where($where)->count();
        return $count;
    }

    //上传图片接口
    public function upload(Request $request){
        $file=$request->file('file');
        // dump($file);
        //验证上传
        $info=$file->validate(['size'=>204800,'ext'=>'png,jpg'])->move('./uploadsd');
        if($info){
            $saveName="/uploadsd/".$info->getSaveName();
            echo json_encode(['content'=>'上传成功','icon'=>1,'code'=>1,'src'=>$saveName]);
        }else{
            echo json_encode(['content'=>$file->getError(),'icon'=>2,'code'=>2]);
        }
    }
}
