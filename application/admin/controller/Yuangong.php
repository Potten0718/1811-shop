<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Yuangong extends Controller
{

    public  function index(){
        $yg_sex=input('get.yg_sex');
        $yg_xl=input('get.yg_xl');
        $where=[];
        if(!empty($yg_sex)){
            $where[]=['yg_sex','=',$yg_sex];
        }
        if(!empty($yg_xl)){
            $where[]=['yg_xl','=',$yg_xl];
        }
    	$data=\app\admin\model\Yuangong::all();
    	$limt=Db::table('shop_yuangong')->where('static',1)->paginate(2);
        $sex=Db::table('shop_yuangong')->where('yg_sex',$yg_sex)->select();
        $xl=Db::table('shop_yuangong')->where('yg_xl',$yg_xl)->select();
    	$this->assign('data',$data);
        $this->assign('limt',$limt);
        $this->assign('sex',$sex);
    	$this->assign('xl',$xl);
    	return $this->fetch();
    }

    public function create(){
    	return $this->fetch();
    }

    public function save(Request $request){
    	if($request->isPost() && $request->isAjax()){
    		$data=$request->post();
    		$res=model('Yuangong')->save($data);
    		if($res){
    			echo json_encode(['content'=>'添加成功','icon'=>1,'code'=>1]);
    		}else{
    			echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
    		}
    	}
    }
}
