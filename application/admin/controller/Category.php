<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\Common;

class Category extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取分类
        $info=model('Category')->select();
        $cate=getCateInfo($info);
        $this->assign('cate',$cate);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //获取分类信息
        $info=model('Category')->select();
        //用函数处理分类的信息
        $cate=getCateInfo($info);
        $this->assign('cate',$cate);
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
        if($request->isPost() && $request->isAjax()){
            //接收数据
            $data=$request->post();
            //验证数据  用validate验证器验证
            $res=model('Category')->save($data);
            if($res){
                echo json_encode(['content'=>'添加成功','icon'=>6,'code'=>1]);
            }else{
                echo json_encode(['content'=>'添加失败','icon'=>5,'code'=>2]);
            }
            
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($cate_id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($cate_id)
    {
        //接收数据
        $data=\app\admin\model\Category::get($cate_id);
        // dump($data);die;
        $this->assign('data',$data);
        return $this->fetch();
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
         $res=\app\admin\model\Category::destroy(input('post.cate_id'));
        echo $res? json_encode(['content'=>'删除成功','icon'=>6,'code'=>1]) : json_encode(['content'=>'删除失败','icon'=>5,'code'=>2]);
    }

    /**
     * 验证姓名的唯一性
     *
     * @param  
     * @return 
     */
    public function checkName(){
        //接收数据
        $cate_name=input('post.cate.name');
        // dump($cate_name);die;
        //查询数量
        $count=db('Category')->where(['cate_name'=>$cate_name])->count();
        echo $count;
    }

    /**
     * 是否显示
     *
     * 
     */
    public function cateShow(){
        $cate_id=input('post.cate_id');
        $cate_show=input('post.cate_show')=='是'?'否':'是';
        $data=['cate_show'=>$cate_show];
        $res=model('Category')->save($data,['cate_id'=>$cate_id]);
        if($res){
            echo json_encode(['content'=>'修改成功','icon'=>6,'code'=>1]);
        }else{
            echo json_encode(['content'=>'修改失败','icon'=>5,'code'=>2]);
        }
    }
}
