<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Role extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=\app\admin\model\Role::all();
        $limt=Db::table('shop_role')->paginate(2);
        $this->assign('limt',$limt);
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
        if($request->isPost() && $request->isAjax() ){
            $data=$request->post();
            $role=model('Role');
            $res=$role->save($data);
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
    public function edit($role_id)
    {
        $data=\app\admin\model\Role::get($role_id);
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
    public function update(Request $request)
    {
        if($request->isPost() && $request->isAjax()){
            $data=$request->post();
            $role_model=model('Role');
            $res=$role_model->save($data,['role_id'=>$data['role_id']]);
            if($res){
                echo json_encode(['content'=>'修改成功','icon'=>1,'code'=>1]);
            }else{
                echo json_encode(['content'=>'修改失败','icon'=>2,'code'=>2]);
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($role_id)
    {
        $res=\app\admin\model\Role::destroy($role_id);
        if($res){
            $this->success('删除成功','role/index');
        }else{
            $this->error('删除失败');
        }
    }

    public function checkOnly(){
        $role_name=input('post.role_name');
        // dump($role_name);die;
        $res=db('Role')->where(['role_name'=>$role_name])->count();
        
        echo $res;
    }
}
