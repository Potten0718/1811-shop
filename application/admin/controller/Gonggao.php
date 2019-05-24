<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Gonggao extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=\app\admin\model\Gonggao::all();
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
        if(request()->isPost() && request()->isAjax()){
            $data=input('post.');
            $validate=validate('Gonggao');
            if(!$validate->check($data)){
                $content=$validate->getError();
                echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
            }
            $res=model('Gonggao')->save($data);
            if($res){
                echo json_encode(['content'=>'添加成功','icon'=>1,'code'=>1]);
            }else{
                echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
            }
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

    //验证标题
    public function checkOnly(){
        $gong_id=input('post.gong_id');
        $gong_title=input('post.gong_title');
        if(empty($gong_id)){
            $where[]=['gong_title','=',$gong_title];
        }else{
            $where[]=['gong_title','=',$gong_title];
            $where[]=['gong_id','=',$gong_id];
        }
        $count=db('gonggao')->where($where)->count();
        return $count;
    }

    //更改状态
    public function editStatus(){
        $gong_id=input('post.gong_id');
        $release_status=input('post.release_status')=='是'?'否':'是';
        $data=['release_status'=>$release_status];
        $res=model('Gonggao')->save($data,['gong_id'=>$gong_id]);
        if($res){
            echo json_encode(['content'=>'修改成功','icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'修改失败','icon'=>2,'code'=>2]);
        }

    }
}
