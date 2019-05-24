<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Shuo extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $info=model('Shuo')->select();
        $shuo=getShuoInfo($info);
        $this->assign('shuo',$shuo);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $info=model('Shuo')->select();
        $shuo=getShuoInfo($info);
        $this->assign('shuo',$shuo);
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
            //接收数据
            $data=$request->post();
            // dump($data);die;
            // 验证数据
            // $validate=validate('Shuo');
            // if(!$validate->check($data)){
            //     $content=$validate->getError();
            //     echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
            // }
            // 入库
            $res=model('Shuo')->save($data);
            // dump($res);die;
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
    public function delete()
    {
        $res=\app\admin\model\Shuo::destroy(input('post.shuo_id'));
        if($res){
            echo json_encode(['content'=>'删除成功','icon'=>1,'code'=>1]);
        }else{
             echo json_encode(['content'=>'删除失败','icon'=>2,'code'=>2]);
        }

    }

    public function checkOnly(){
        $shuo_name=input('post.shuo_name');
        $shuo_id=input('post.shuo_id');
        if(empty($shuo_id)){
            $where[]=['shuo_name','=',$shuo_name];
        }else{
            $where[]=['shuo_name','=',$shuo_name];
            $where[]=['shuo_id','<>',$shuo_id];
        }
        $count=db('shuo')->where($where)->count();
        return $count;
    }
}
