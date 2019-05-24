<?php

namespace app\index\controller;

use think\Controller;

class Cart extends Common
{
	//加入购物车
	public function addCart(){
		$goods_id=input('post.goods_id',0,'intval');
		$buy_number=input('post.buy_number',0,'intval');
		// dump($goods_id);die;
		//验证
		if(empty($goods_id)){
			fail('请选择一件商品');
		}
		$goodsWhere=[
			['goods_id','=',$goods_id],
			['is_on_sale','=',1]
		];
		$goods_model=model('Goods');
		$goodsInfo=$goods_model->where($goodsWhere)->find();
		if(empty($goodsInfo)){
			fail('请选择一件商品');
		}

		//加入购物车
		if($this->checkLogin()){
			$this->saveCartInfoDb($goods_id,$buy_number,$goodsInfo['goods_price']);
		}else{
			$this->saveCartInfoCookie($goods_id,$buy_number,$goodsInfo['goods_price']);
		}
		exit;
	}

	//加入购物车进数据库
	public function saveCartInfoDb($goods_id,$buy_number,$add_price){
		//根据商品id 用户id在购物车表中进行查询
		$cart_model=model('Cart');
		$user_id=$this->getUserId();
		$cartWhere=[
			['goods_id','=',$goods_id],
			['user_id','=',$user_id],
			['is_del','=',1]
		];
		$cartInfo=$cart_model->where($cartWhere)->find();
		// dump($cartInfo);die;
		if(!empty($cartInfo)){
			//检测库存 累加
			$res=$this->checkGoodsNum($buy_number,$goods_id,$cartInfo['buy_number']);
			if(!$res){
				fail('库存不足');
			}
			$where=[
				['goods_id','=',$goods_id],
			];
			$result=$cart_model->where($where)->update(['buy_number'=>$buy_number+$cartInfo['buy_number']]);
			// dump($result);die;
		}else{
			//检测库存 添加
			$res=$this->checkGoodsNum($buy_number,$goods_id);
			if(!$res){
				fail('库存不足');
			}
			$info=[
				'goods_id'=>$goods_id,
        'add_price'=>$add_price,
				'user_id'=>$user_id,
				'buy_number'=>$buy_number
			];
			$result=$cart_model->save($info);
			// dump($result);die;
		}
		if($result){
			successly('加入购物车成功');
		}else{
			fail('加入购物车失败');
		}
	}

	//加入购物车到cookie
	public function saveCartInfoCookie($goods_id,$buy_number,$add_price){
		$str=cookie('cartInfo');
		$flag=0;
		//判断cookie中是否有值
		if(!empty($str)){
			$cartInfo=getBase64Info($str);
			//当前购买商品id 是否在cookie中出现过
			foreach ($cartInfo as $k => $v) {
					if($goods_id==$v['goods_id']){
						//检测库存
						$res=$this->checkGoodsNum($buy_number,$goods_id,$v['buy_number']);
						if(!$res){
							fail('库存不足');
						}
						//累加
						$cartInfo[$k]['buy_number']=$buy_number+$v['buy_number'];
						// dump($cartInfo);die;
					}else{
						$flag=1;
					}
			}
			//添加
			if($flag==1){
				//检测库存
				$res=$this->checkGoodsNum($buy_number,$goods_id);
				if(!$res){
					fail('库存不足');
				}
				$cartInfo[]=[
					'goods_id'=>$goods_id,
					'buy_number'=>$buy_number,
					'create_time'=>time()
				];
			}	
			//把累加或添加的购物车数据存储到cookie中去
			$str=createBase64Info($cartInfo);
			cookie('cartInfo',$str);
		}else{
			//检测库存
			$res=$this->checkGoodsNum($buy_number,$goods_id);
			if(!$res){
				fail('库存不足');
			}
			//把数据存入cookie中
			$cartInfo=[
				['goods_id'=>$goods_id,'buy_number'=>$buy_number,'create_time'=>time()]
			];
			$str=createBase64Info($cartInfo);
			// dump($str);die;
			cookie('cartInfo',$str);
		}
			successly('加入购物车成功');
	}

	//购物车展示页面
  public function cartList()
  {
        if($this->checkLogin()){
            $cartInfo=$this->getCartInfoDb();
        }else{
            $cartInfo=$this->getCartInfoCookie();
        }
        // print_r($cartInfo);exit;
        if(!empty($cartInfo)){
            $count=0;
            foreach ($cartInfo as $k => $v) {
                $count+=$v['goods_price']*$v['buy_number'];
            }
        }
        $this->assign('count',$count);
        $this->assign('cartInfo',$cartInfo);
        $this->getCateInfo();
        return view();
  }

  //从数据库中获取购物车数据
  public function getCartInfoDb()
  {
        $user_id=$this->getUserId();
        $where=[
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        $cart_model=model('Cart');
        $cartInfo=$cart_model
        ->field('c.goods_id,goods_name,buy_number,goods_price,goods_img,goods_num,add_price')
        ->alias('c')
        ->join('shop_goods g','c.goods_id=g.goods_id')
        ->where($where)
        ->order('c.create_time','desc')
        ->select();
        if(!empty($cartInfo)){
            return $cartInfo;
        }else{
            return false;
        }
  }

  //从cookie中获取购物车数据
  public function getCartInfoCookie()
  {
        $str=cookie('cartInfo');
        if(!empty($str)){
            $cartInfo=getBase64Info($str);
            $cartInfo=array_reverse($cartInfo);
            $goods_id=[];
            foreach ($cartInfo as $k => $v) {
                $goods_id[]=$v['goods_id'];
            }
            // print_r($goods_id);exit;
            if(empty($goods_id)){
                return false;
            }else{
                $g_id=implode(',', $goods_id);
                $goods_model=model('Goods');
                $exp = new \think\db\Expression("field(goods_id,$g_id)");
                $where=[
                    ['goods_up','=',1],
                    ['goods_id','in',$g_id]
                ];
                // print_r($cartInfo);
               $goodsInfo=$goods_model->where($where)->order($exp)->select()->toArray();
               // print_r($goodsInfo);exit;
               foreach ($goodsInfo as $k => $v) {
                  foreach ($cartInfo as $key => $val) {
                      if($v['goods_id']==$val['goods_id']){
                        $goodsInfo[$k]['buy_number']=$val['buy_number'];
                      }
                    }
               }
               // print_r($goodsInfo);die;
               return $goodsInfo;
            }
            // print_r($goodsInfo);exit;
        }else{
            return false;
        }
  }
  

  // 改变购买数量
  public function changeNum()
  {
        $goods_id=input('post.goods_id',0,'intval');
        $buy_number=input('post.buy_number',0,'intval');
        if($buy_number<1){
        	fail('最少购买一件');
        }
        if($this->checkLogin()){
        	//改变数据库的购买数量
        	$this->changeNumDb($goods_id,$buy_number);
        }else{
        	//改变cookie的购买数量
        	$this->changeNumCookie($goods_id,$buy_number);
        }
  }

  //改变数据库的购买数量
  public function changeNumDb($goods_id,$buy_number){
      $user_id=$this->getUserId();
      	//检测库存 添加
	   $res=$this->checkGoodsNum($buy_number,$goods_id);
	   if(!$res){
	     	fail('库存不足');
	   }
        $where=[
            ['user_id','=',$user_id],
            ['goods_id','=',$goods_id],
            ['is_del','=',1]
        ];
        $result=model('Cart')->where($where)->update(['buy_number'=>$buy_number]);
        if($result){
           	successly('');
        }else{
            fail('修改失败');
        }
  }

  //改变cookie的购买数量
  public function changeNumCookie($goods_id,$buy_number){
    $str=cookie('cartInfo');
    if(!empty($str)){
    	$info=getBase64Info($str);
    }
    foreach($info as $k=>$v){
    	if($v['goods_id']==$goods_id){
    	//检测库存
    	$res=$this->checkGoodsNum($buy_number,$goods_id);
			if(!$res){
			fail('库存不足');
			}
    	$info[$k]['buy_number']=$buy_number;
    	$s=createBase64Info($info);
    	cookie('cartInfo',$s);

    	}
  	}
  }
 
  //获取小计
  public function getTotal(){
    	$goods_id=input('post.goods_id',0,'intval');
    	//获取商品价格
    	// dump($goods_id);die;
    	$goods_model=model('Goods');
    	$goodsWhere=[
    		['goods_id','=',$goods_id],
    		['is_on_sale','=',1]
    	];
    	$goods_price=$goods_model->where($goodsWhere)->value('goods_price');
    	// dump($goods_price);die;
    	//获取购买数量
    	if($this->checkLogin()){
    		//从数据库中获取
    		$cart_model=model('Cart');
    		$user_id=$this->getUserId();
    		$cartWhere=[
    			['goods_id','=',$goods_id],
    			['user_id','=',$user_id],
    			['is_del','=',1]
    		];
    		$buy_number=$cart_model->where($cartWhere)->value('buy_number');
    	}else{
    		//从cookie中获取
    		$str=cookie('cartInfo');
    		if(!empty($str)){
    			$info=getBase64Info($str);
    			foreach ($info as $k => $v) {
    				if($v['goods_id']==$goods_id){
    					$buy_number=$v['buy_number'];	
    				}
    			}
    		}
    	}
    	echo $goods_price*$buy_number;
  }

  //获取总价
   public function getCount(){
   		$goods_id=input('post.goods_id');
   		// dump($goods_id);die;
   		if($this->checkLogin()){
   			//从数据库中获取 购买数量 商品价格
   			$user_id=$this->getUserId();
   			$cart_model=model('Cart');
   			$cartWhere=[
   				['c.goods_id','in',$goods_id],
   				['user_id','=',$user_id],
   				['is_del','=',1]
   			];
   			$info=$cart_model
   			->field('buy_number,goods_price')
   			->alias('c')
   			->join('shop_goods g','c.goods_id=g.goods_id')
   			->where($cartWhere)
   			->select();
   			// dump($cart_model->getLastSql());die;
   			// dump($info);die;
   		}else{
   			//从cookie中获取购买数量 从数据库中获取商品价格
   			$goods_model=model('Goods');
   			$goodsWhere=[
   				['goods_id','in',$goods_id],
   				['is_on_sale','=',1]
   			];
   			$info=$goods_model
   			->field('goods_id,goods_price')
   			->where($goodsWhere)
   			->select();
   			$str=cookie('cartInfo');
   			$cartInfo=getBase64Info($str);
   			foreach ($info as $k => $v) {
   				foreach ($cartInfo as $key => $value) {
   					if($v['goods_id']==$value['goods_id']){
   						$info[$k]['buy_number']=$value['buy_number'];
   					}
   				}
   			}
   		}
   		$count=0;

   		//总价
   		foreach ($info as $k => $v) {
   			$count+=$v['goods_price']*$v['buy_number'];
   		}
   		echo $count;
   }

  //删除
  public function cartDel(){
   	$goods_id=input('post.goods_id');
   	// dump($goods_id);die;
   	if(empty($goods_id)){
   		fail('请至少选择一件商品进行删除');
   	}
   	if($this->checkLogin()){
    $this->cartDelDb($goods_id);
   	}else{
      $this->cartDelCookie($goods_id);
    }
   }

  //登陆---从数据库中删除购物车
  public function cartDelDb($goods_id){
      $user_id=$this->getUserId();
      $where=[
        ['user_id','=',$user_id],
        ['goods_id','in',$goods_id]
      ];
      $res=model('Cart')->where($where)->update(['is_del'=>2]);
      if($res){
        successly('删除成功');
      }else{
        fail('删除失败');
      }
  } 

  //未登陆---从cookie中删除商品数据
  public function cartDelCookie($goods_id){
    $str=cookie('cartInfo');
    if(!empty($str)){
      $cartInfo=getBase64Info($str);
      if(strpos($goods_id,',')){
        //批量删除
        $del_id=explode(',',$goods_id);
      }else{
        //单删
        $del_id=[$goods_id];
      }
      foreach ($cartInfo as $k => $v) {
        if(in_array($v['goods_id'], $del_id)){
          unset($cartInfo[$k]);
        }
      }
      if(empty($cartInfo)){
        cookie('cartInfo',null);
      }else{
        $cartStr=createBase64Info($cartInfo);
        cookie('cartInfo',$cartStr);
      }

      successly('删除成功！');
    }
  } 

  //确认结算
  public function conform(){
    //检查是否登陆
    if(!$this->checkLogin()){
      $this->error('请先登陆','login/login');
    }

    $goods_id=input('get.goods_id');
    if(empty($goods_id)){
      $this->error('请至少选择一件商品进行结算','cart/cartList');
    }

    $user_id=$this->getUserId();
    $where=[
      ['user_id','=',$user_id],
      ['c.goods_id','in',$goods_id],
      ['is_on_sale','=',1]
    ];

    // 获取商品数据
    $goods_model=model('Goods');
    $goodsInfo=$goods_model
    ->alias('g')
    ->join("cart c","g.goods_id=c.goods_id")
    ->where($where)
    ->select();
    
    //获取商品总价
    $count=0;
    foreach ($goodsInfo as $k => $v) {
      $count+=$v['goods_price']*$v['buy_number'];
    }

    //查询当前用户的收货地址
    $addressInfo=$this->getAddressInfo();
    $this->assign('goodsInfo',$goodsInfo);
    $this->assign('count',$count);
    $this->assign('addressInfo',$addressInfo);
    $this->getCateInfo();
    return $this->fetch();
  } 

	//测试cookie中的数据
	public function test(){
		$str=cookie('cartInfo');
		$info=getBase64Info($str);
		dump($info);die;
	} 
}
