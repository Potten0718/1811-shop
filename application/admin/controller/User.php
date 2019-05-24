<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Admin;

class User extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //查询数据
        // $data=Admin::all();
        $data=model('admin')->select();
        //分配数据到视图
        $this->assign('data',$data);
        // 调用视图
        return $this->fetch();
    }

    /**
     * 添加用户.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 添加用户的处理
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收表单数据
        $data=$request->post();
        // $validate=new app\admin\validate\User;
        $validate=validate('User');
        if(!$validate->check($data)){
            $this->error($validate->getError());
        }
        // 使用模型进行数据入库
        $result=Admin::create($data);
        // 判断入库是否成功
        if($result->admin_id){
            $this->success('用户添加成功','user/index');
        }else{
            $this->error('用户添加失败');
        }
        // dump($data);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $admin_id
     * @return \think\Response
     */
    public function read($admin_id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $admin_id
     * @return \think\Response
     */
    public function edit($admin_id)
    {
        //取出原数据
        $data=Admin::get($admin_id);
        //分配数据到编辑页面
        $this->assign('data',$data);
        //调用视图
        return $this->fetch();   
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $admin_id
     * @return \think\Response
     */
    public function update(Request $request)
    {
        //接收表单数据
        $data=$request->post();
        //验证数据
        $validate=validate('User');
        if(!$validate->scene('update')->check($data)){
           $this->error($validate->getError());
        }
        //更新数据
        $result=model('Admin')->save($data,['admin_id'=>$data['admin_id']]);
        // dump($result);exit;
        // 判断更新结果
        if($result){
            $this->success('修改成功','user/index');
        }else{
            $this->error('修改失败');
        }
    }    

    /**
     * 删除指定资源
     *
     * @param  int  $admin_id
     * @return \think\Response
     */
    public function delete($admin_id)
    {
        $result=Admin::get($admin_id)->delete();
        if($result){
            $this->success('删除成功','user/index');
        }else{
            $this->error('删除失败');
        }
    }
}
