<?php

namespace app\index\controller;

use think\Controller;

class Index extends Common
{
    public function index(){
    	//获取楼层数据
    	$cate_id=1;
    	$floorInfo=$this->getFloorInfo($cate_id);
    	
    	// $this->getLeftCateInfo();
    	$this->assign('floorInfo',$floorInfo);
    	$this->getCateInfo();
    	return $this->fetch();
    }

    //获取楼层数据
    public function getFloorInfo($cate_id){
    	$cate_model=model('Category');
    	//1.获取顶级分类的ID名称
    	$topWhere=[
    		['cate_id','=',$cate_id],
    		['cate_show','=',1]
    	];
    	$info['topInfo']=$cate_model->field('cate_id,cate_name')->where($topWhere)->find();
     
     	//2.获取顶级分类下的二级分类的ID名称
    	$secondWhere=[
    		['cate_pid','=',$cate_id],
    		['cate_show','=',1]
    	];
    	$info['secondInfo']=$cate_model->field('cate_id,cate_name')->where($secondWhere)->select();
    	// $cate_pid($secondInfo);exit; 
    
    	//3.获取商品数据  3.1获取当前顶级分类下的所有子级分类
    	$cateInfo=$cate_model->where('cate_show',1)->select();
    	$id=getCateId($cateInfo,$cate_id);
    	$goods_model=model('Goods');
    	$goodsWhere=[
    		['cate_id','in',$id],
    	];
    	$info['goodsInfo']=$goods_model->where($goodsWhere)->limit('8')->select();
    	return $info;

    }

    //获取下一楼层数据
    public function getMore(){
     $cate_id=input('post.cate_id',0,'intval');
     $floor_num=input('post.floor_num',0,'intval');
     // dump($cate_id);die;
     if(empty($cate_id)){
        echo "此分类下没有数据";
     }
     $where=[
        ['cate_pid','=','0'],
        ['cate_id','>',$cate_id]
     ];
     $cate_model=model('Category');
     $cate_id=$cate_model->where($where)->order('cate_id','asc')->limit(1)->value('cate_id');
     $info=$this->getFloorInfo($cate_id);
     $floor_num+=1;
     $this->assign('floor_num',$floor_num);
     $this->view->engine->layout(false);
     $this->assign('floorInfo',$info);
     echo $this->fetch("div");
    }
    

    
}
