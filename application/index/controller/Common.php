<?php

namespace app\index\controller;

use think\Controller;
use think\facade\Request;

class Common extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    	$controller_name=Request::controller();
    	// dump($controller_name);die;
    	if($controller_name=='Index'){
    		$is_show='leftNav';
    	}else{
    		$is_show='leftNav none';
    		// dump($is_show);die;
    	}	
    	$this->assign('is_show',$is_show);
    }

    //获取商品导航栏和左侧数据
    public function getCateInfo(){
        //查询导航栏数据
        $cate_model=model('Category')->where(['cate_nav'=>1])->select();
        // dump($cate_model);die;
        $this->assign('cate_model',$cate_model);
        //查询左侧数据
        $leftCateInfo=model('Category')->where(['cate_show'=>1])->select();
        // $cateInfo=[
        //  [
        //     'cate_id'=>1,
        //     'cate_name'=>'男装',
        //     'son'=>[
        //         [
        //             'cate_id'=>10,
        //             'cate_name'=>'精品上装',
        //             'son'=>[
        //                 [
        //                     'cate_id'=>20,
        //                     'cate_name'=>'衬衫'
        //                 ],
        //                 [
        //                     'cate_id'=>21,
        //                     'cate_name'=>'小西服'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'cate_id'=>11,
        //             'cate_name'=>'精品下装',
        //             'son'=>[
        //                 [
        //                     'cate_id'=>22,
        //                     'cate_name'=>'工装裤'
        //                 ],
        //                 [
        //                     'cate'=>23,
        //                     'cate_name'=>'运动裤'
        //                 ]
        //             ]
        //         ]
        //     ]
        //  ],
        //  [
        //     'cate_id'=>2,
        //     'cate_name'=>'女装',
        //     'son'=>[
        //         [
        //             'cate_id'=>'13',
        //             'cate_name'=>'连衣裙',
        //             'son'=>[
        //                 [
        //                     'cate_id'=>'26',
        //                     'cate_name'=>'仙女连衣裙'
        //                 ],
        //                 [
        //                     'cate_id'=>'27',
        //                     'cate_name'=>'连衣裙'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'cate_id'=>'14',
        //             'cate_name'=>'内衣',
        //             'son'=>[
        //                 [
        //                     'cate_id'=>'28',
        //                     'cate_name'=>'运动内衣'
        //                 ],
        //                 [
        //                     'cate_id'=>'29',
        //                     'cate_name'=>'无痕内衣'
        //                 ]
        //             ]
        //         ]
        //     ]
        //  ]
        // ];
        // 调用无限极分类函数
        $cateInfo=getLeftCateInfo($leftCateInfo);
        $this->assign('cateInfo',$cateInfo);
    }

    //检测是否登陆
    public function checkLogin(){
        return session('?uinfo');
    }

    //获取用户iD
    public function getUserId(){
        return session('uinfo.user_id');
    }

    //同步浏览历史记录
    public function asyncHistory(){
        //取出coolie中的信息 存到数据库中
        $str=cookie('historyInfo');
        if(!empty($str)){
            $info=getBase64Info($str);
            foreach ($info as $k => $v) {
                $info[$k]['user_id']=$this->getUserId();
            }
            $res=model('History')->saveAll($info);
            if($res){
                cookie('userInfo',null);
            }
        }
    }

    //同步购物车
    public function asyncCart()
    {
        $str=cookie('cartInfo');
        if(!empty($str)){
            $cartInfo=getBase64Info($str);
            $user_id=$this->getUserId();
            $cart_model=model('Cart');
            foreach ($cartInfo as $k => $v) {
                $where=[
                    ['user_id','=',$user_id],
                    ['goods_id','=',$v['goods_id']],
                    ['is_del','=',1]
                ];
                $info=$cart_model->where($where)->find();
                if(!empty($info)){
                    $res=$this->checkGoodsNum($v['buy_number'],$v['goods_id'],$info['buy_number']);
                    if(!$res){
                        echo json_encode(['content'=>'库存不足','icon'=>5,'code'=>2]);exit;
                    }

                    $cartWhere=[
                        ['is_del','=',1],
                        ['cart_id','=',$info['cart_id']]
                    ];
                    $cart_model->where($cartWhere)->update(['buy_number'=>$info['buy_number']+$v['buy_number']]);
                }else{
                    $res=$this->checkGoodsNum($v['buy_number'],$v['goods_id']);
                    if(!$res){
                        echo json_encode(['content'=>'库存不足','icon'=>5,'code'=>2]);exit;
                    }
                    $v['user_id']=$user_id;
                    $v['update_time']=time();
                    $cart_model->insert($v);
                }
            }
            cookie('cartInfo',null);
        }
    }



    //检测库存
    public function checkGoodsNum($buy_number,$goods_id,$already_number=0){
        $num=$buy_number+$already_number;
        $goods_num=model('Goods')->where('goods_id',$goods_id)->value('goods_num');
        if($num>$goods_num){
            return false;
        }else{
            return true;
        }
    }


    function getLeftCateInfo($cateInfo,$cate_pid=0){
        $info=[];
        foreach ($cateInfo as $k => $v){
            if($v['cate_pid']==$cate_pid){
             $v['son']=getLeftCateInfo($cateInfo,$v['cate_id']);
             $info[]=$v;
          }
        }
        return $info;
    }

    //获取收货地址信息
    public function getAddressInfo(){
        $address_model=model('Address');
        $user_id=$this->getUserId();
        $where=[
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        $addressInfo=$address_model->where($where)->select();
        if(!empty($addressInfo)){
            //处理 省市区
            $area_model=model('Area');
            // dump($aa);die;
            foreach ($addressInfo as $k => $v) {
                $addressInfo[$k]['province']=$area_model->where('id',$v['province'])->value('name');
                $addressInfo[$k]['city']=$area_model->where('id',$v['city'])->value('name');
                $addressInfo[$k]['area']=$area_model->where('id',$v['area'])->value('name');
            }
        }

        return $addressInfo;  
    }
}
