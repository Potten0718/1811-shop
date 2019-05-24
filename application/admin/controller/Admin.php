<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Admin as Adm;
use app\admin\controller\Common;

class Admin extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch();
    }

     /**
     * 显示资源列表
     *
     * @return json
     */
    public function indexdata()
    {  
       //接收分页参数
       $page=input('get.page');
       $limit=input('get.limit');
       //根据分页参数获取数据
       $data=model('Admin')->page($page,$limit)->select(); 
       $count=db('Admin')->count();
       //返回的数据格式：code接口状态  msg提示信息
       $info=['code'=>0,'count'=>$count,'data'=>$data];
       echo json_encode($info);
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
        // 接收ajax传来的数据
        if($request->isPost() && $request->isAjax()){
            //接收数据
            $data=$request->post();
            // dump($data);die;
            //数据验证
            //数据入库
            $admin= model('Admin');
            $res=$admin->save($data);
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
    public function edit($admin_id)
    {
        $data=Adm::get($admin_id);
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
    public function update(Request $request)
    {
        if($request->isPost() && $request->isAjax()){
            //接收表单信息
            $data=$request->post();
            //数据验证（略）
            $admin=new Adm;
            $res=$admin->save($data,['admin_id'=>$data['admin_id']]);
            //判断入库结果
            echo $res ? json_encode(['content'=>'修改成功','icon'=>6,'code'=>1]) :json_encode(['content'=>'修改失败','icon'=>5,'code'=>2]);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        $res=\app\admin\model\Admin::destroy(input('post.admin_id'));
        echo $res? json_encode(['content'=>'删除成功','icon'=>6,'code'=>1]) : json_encode(['content'=>'删除失败','icon'=>5,'code'=>2]);
    }

    /**
     * 验证用户名唯一性资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function checkName(){
        //获取ajax传来的数据
        $admin_name=input('post.admin_name');
        $admin_id=input('post.admin_id');
        if(empty($admin_id)){
            $where[]=['admin_name','=',$admin_name];
        }else{
            $where[]=['admin_name','=',$admin_name];
            $where[]=['admin_id','neq',$admin_id];
        }
        //验证唯一性
        $count=db('Admin')->where($where)->count();
        //对ajax做出响应
        echo $count;
    }
    /**
     * ajax编辑表格
     * 
     * @param  
     * @return json
     */
    public function editTable(){
        //接收ajax数据
        $admin_id=input('post.admin_id');
        $fieldName=input('post.fieldName');
        $fieldValue=input('post.fieldValue');
        //入库
        $admin=new Adm;
        $res=$admin->save([$fieldName=>$fieldValue],['admin_id'=>$admin_id]);
        // dump($res);die;
        //判断 返回
        if($res){
            echo json_encode(['content'=>'修改成功','cion'=>6,'code'=>1]);
        }else{
            echo json_encode(['content'=>'修改失败','cion'=>5,'code'=>2]);
        }
    }

    /**
     * 修改密码
     * 
     * @param  
     * @return json
     */
    public function updatePass(){
        //判断请求类型
        if(request()->isPost() && request()->isAjax()){
            //接收表单数据
            $data=input('post.');
            // dump($data);
            //数据验证(非空、正则、两次密码是否一致)
            if($data['new_pwd'] != $data['new_repwd']){
                echo json_encode(['content'=>'输入的两次密码不一致','icon'=>2,'code'=>2]);die;
            }else if($data['new_pwd'] == $data['old_pwd']){
                echo json_encode(['content'=>'新密码不能和原则密码一致','icon'=>2,'code'=>2]);die;
            }
        //设置查询 修改条件
        $where=['admin_id'=>$data['admin_id']];
        //取出用户信息
        $info=db('Admin')->where($where)->find();
        //将用户输入的原密码进行加密
        $old_pwd=createPwd($data['old_pwd'],$info['admin_salt']);
        //将用户的原密码与数据库的密码进行比对
        if($old_pwd != $info['admin_pwd']){
            echo json_encode(['content'=>'原密码错误','icon'=>2,'code'=>2]);
        }else{
            //修改密码
            $res=model('Admin')->save(['admin_pwd'=>$data['new_pwd'],'admin_status'=>$data['admin_status']],$where);
            //判断返回结果
            if($res){
                echo json_encode(['content'=>'修改成功','icon'=>1,'code'=>1]);
            }else{
                echo json_encode(['content'=>'修改失败','icon'=>2,'code'=>2]);
            }
        }
    }else{
       return $this->fetch();
    }
   }

}
