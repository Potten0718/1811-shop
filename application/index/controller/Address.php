<?php

namespace app\index\controller;

use think\Controller;

class Address extends Common
{

	//防非法登陆
	public function __construct(){
		parent::__construct();
		if(!$this->checkLogin()){
			$this->error('请先登陆！');
		}
	}

    //显示添加收货地址的视图
    public function addressAdd(){
    	//查询当前用户的收货地址信息
    	$addressInfo=$this->getAddressInfo();
    	// dump($addressInfo);die;
    	//查询所有的省份信息
    	$provinceInfo=$this->getAreaInfo(0);
    	// dump($provinceInfo);die;
    	$this->assign('provinceInfo',$provinceInfo);
    	$this->assign('addressInfo',$addressInfo);
    	return view();
    }

    //获取区域信息
    public function getAreaInfo($pid){
    	$where=[
    		['pid','=',$pid]
    	];
    	$area_model=model('Area');
    	$areaInfo=$area_model->where($where)->select();
    	return $areaInfo;
    }

    //获取区域
    public function getArea(){
    	$id=input('post.id',0,'intval');
    	// dump($id);die;
    	$info=$this->getAreaInfo($id);
    	echo json_encode($info);
    }

    //收货地址的添加
    public  function addressDoadd(){
    	$data=input('post.');
    	$user_id=$this->getUserId();
    	$data['user_id']=$user_id;
    	//用validate验证
    	
    	$address_model=model('Address');
    	if($data['is_default']==1){
    		$where=[
    			['user_id','=',$user_id],
    			['is_del','=',1]
    		];
    		$address_model->where($where)->update(['is_default'=>2]);
    	}
    	$res=$address_model->save($data);
    	if($res){
    		successly('添加成功');
    	}else{
    		fail('添加失败');
    	}
    }

    //收货地址的删除
    public function addressDel(){
    	$address_id=input('post.address_id');
    	$user_id=$this->getUserId();
    	$address_model=model('Address');
    	$where=[
    		['user_id','=',$user_id],
    		['address_id','=',$address_id]
    	];
    	$is_del=2;
    	$res=$address_model->where($where)->update(['is_del'=>$is_del]);
    	if($res>0){
    		successly('删除成功');
    	}else{
    		fail('删除失败');
    	}
    }

    //修改收货人信息
    public  function addressEdit(){
    	$address_id=input('get.address_id',0,'intval');
    	if(empty($address_id)){
    		$this->error("请选择要修改的收货地址","{:url('address/addressAdd')}");
    	}

    	//根据当前的id 选择要修改的数据
    	$where=[
    		['address_id','=',$address_id],
    		['is_del','=',1]
    	];
    	$address_model=model('Address');
    	$addressInfo=$address_model->where($where)->find();
    	// dump($addressInfo);die;
    	//查询 所有的省份 作为第一个下拉菜单
    	$provinceInfo=$this->getAreaInfo(0);
    	//获取选择省下 市的信息
    	$cityInfo=$this->getAreaInfo($addressInfo['province']);
    	//获取选择市下 区、县的信息
    	$areaInfo=$this->getAreaInfo($addressInfo['city']);

    	$this->assign('provinceInfo',$provinceInfo);
    	$this->assign('addressInfo',$addressInfo);
    	$this->assign('cityInfo',$cityInfo);
    	$this->assign('areaInfo',$areaInfo);
    	return $this->fetch();
    }

    //执行修改
    public  function addressEditDo(){
    	$data=input('post.');
    	// dump($data);die;
    	$user_id=$this->getUserId();
    	$address_model=model('Address');
    	if($data['is_default']==1){
    		$where=[
    			['user_id','=',$user_id],
    			['is_del','=',1]
    		];
    		$address_model->where($where)->update(['is_default'=>2]);	
    	}
    	$addressWhere=[
    		['address_id','=',$data['address_id']],
    		['is_del','=',1],
    		['user_id','=',$user_id]
    	];
    	$res=$address_model->where($addressWhere)->update($data);
    	if($res>0){
    		successly('修改成功');
    	}else{
    		fail('修改失败');
    	}
    }

    //修改默认设置的地址
    public function addressMoren(){
   	    $address_id=input('post.address_id');
    	// dump($data);die;
    	$user_id=$this->getUserId();
    	if(empty($address_id)){
    		fail('请选择一个收货地址');
    	}
    	$address_model=model('Address');
    		$where=[
    			['user_id','=',$user_id],
    			['is_del','=',1]
    		];
    		$addressWhere=[
    			['address_id','=',$address_id],
    			['is_del','=',1],
    			['user_id','=',$user_id]
    		];
    	$address_model->where($where)->update(['is_default'=>2]);
    	
    	$res=$address_model->where($addressWhere)->update(['is_default'=>1]);
    	if($res>0){
    		successly('设置默认成功');
    	}else{
    		fail('设置默认失败');
    	}
    	
    }

}
