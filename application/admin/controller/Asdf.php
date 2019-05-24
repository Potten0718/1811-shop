<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
class Asdf extends Controller
{
    public  function index(){
    	return $this->fetch();
    }

    public  function create(){
    	return $this->fetch();
    }

    public  function save(Request $request){
    	if($request->isPost() && $request->isAjax()){
    		$data=input('post.');
    		//validate验证
    		$validate=validate('Asdf');
    		if(!$validate->check($data)){
    			$content=$validate->getError();
    			echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
    		}
    		//入库
    		$res=model("Asdf")->save($data);
    		if($res){
    			echo json_encode(['content'=>'添加成功','icon'=>1,'code'=>1]);
    		}else{
    			echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
    		}
    	}
    } 

    //验证用户名唯一性
    public function checkName(){
    	$asdf_name=input('post.asdf_name');
 		// dump($asdf_name);die;
    	$count=model('Asdf')->where('asdf_name',$asdf_name)->count();
    	echo $count;
    }


}
