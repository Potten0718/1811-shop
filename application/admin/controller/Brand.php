<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\Common;

class Brand extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //调用视图
        return $this->fetch();
    }

     /**
     * 数据接口
     *
     * @return \think\Response
     */
     public function indexData(){
        //获取品牌信息
        $data=model('Brand')->select();
        //返回固定格式的数据
        $info=['code'=>0,'data'=>$data];
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
     * 上传接口.
     *
     */
    public function upload(Request $request){
        //接收上传数据
        $file=$request->file('file');
        //上传验证
        $info=$file->validate(['size'=>204800,'ext'=>'jpg,peg'])->move('./uploads');
        //验证结果
        if($info){
            $saveName="/uploads/".$info->getSaveName();
            echo json_encode(['content'=>'上传成功','icon'=>1,'code'=>1,'src'=>$saveName]);
        }else{
            echo json_encode(['content'=>$file->getError(),'icon'=>2,'code'=>2]);
        }
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
            // var_dump($data);die;
            //验证数据
            $validate=validate('Brand');
            if(!$validate->check($data)){
                $content = $validate->getError();
                echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
            }
            //数据入库
            $res=model('Brand')->save($data);
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
    public function update($brand_id)
    {
         
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($brand_id)
    {
        $data=\app\admin\model\Brand::get($brand_id);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($brand_id)
    {
        //获取数据
        $brand=\app\admin\model\Brand::get($brand_id);
        $res=$brand->delete();
        if($res){
            @unlink($brand->brand_logo);
            echo json_encode(['content'=>'删除成功','icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'删除失败','icon'=>2,'code'=>2]);
        }
    }

    /**
     * 验证品牌名的唯一性
     *
     * @param  
     * @return 
     */
    public function checkName(){
        //获取ajax传来的数据
        $brand_name=input('post.brand_name');
        $brand_id=input('post.brand_id');
        if(empty($brand_id)){
            $where[]=['brand_name','=',$brand_name];
        }else{
            $where[]=['brand_name','=',$brand_name];
            $where[]=['brand_id','neq',$brand_id];
        }
        //验证唯一性
        $count=db('Brand')->where($where)->count();
        //对ajax做出响应
        echo $count;
    }

    /**
     * 编辑单元格接口
     *
     *   
     * 
     */
    public function editTable(){
        //接收ajax数据
        $fieldName=input('post.fieldName');
        $fieldValue=input('post.fieldValue');
        $brand_id=input('post.brand_id');
        //修改数据
        $res=model('Brand')->save([$fieldName=>$fieldValue],['brand_id'=>$brand_id]);
        if($res){
            echo json_encode(['content'=>'修改成功','icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'修改','icon'=>2,'code'=>2]);
        }
    }


}
