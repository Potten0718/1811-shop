<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Order extends Common
{
   // 确认订单
    public function confirmOeder()
    {
       // echo 1111;die;
        $goods_id=input('post.goods_id');
        $address_id=input('post.address_id');
        $pay_type=input('post.pay_type');
        $order_talk=input('post.order_talk');
        $order_model=model('Order');
        dump($goods_id);
        dump($address_id);
        dump($pay_type);
        dump($order_talk);die;
        // 开启事务
        $order_model->startTrans();
        try{
            // 验证是否为空

            

            // 添加订单表数据
            $order['user_id']=$this->getUserId();
            $order['order_no']=$this->getOrderNo();
            $order['order_amount']=$this->getOrderAmount($goods_id);
            $order['order_talk']=$order_talk;
            $order['pay_type']=$pay_type;
            $res=$order_model->save($order);
            // print_r($res);exit;
            if(empty($res)){
                throw new \Exception('订单信息写入失败');
            }




            // 获取刚刚添加的订单id
            $order_id=$order_model->order_id;

            // 添加订单收获地址表数据
            $address_model=model('OrderAddress');
            $add_model=model('Address');
            $addressInfo=$add_model->where('address_id',$address_id)->find();
            if(empty($addressInfo)){
                throw new \Exception('收获地址不存在');
            }
            unset($addressInfo['create_time']);
            unset($addressInfo['update_time']);
            unset($addressInfo['is_del']);
            $addressInfo=$addressInfo->toArray();
            $addressInfo['order_id']=$order_id;
            $res1=$address_model->save($addressInfo);
            // dump($res1);die;
            if(empty($res1)){
                throw new \Exception('订单收获地址写入失败');
            }




            // 添加订单商品表数据
            $detail_model=model('OrderDetail');
            $cart_model=model('Cart');
                $user_id=$this->getUserId();
                $where=[
                    ['is_del','=',1],
                    ['user_id','=',$user_id],
                    ['c.goods_id','in',$goods_id]
                ];
                $cartInfo=$cart_model
                    ->field('buy_number,g.goods_id,goods_price,goods_img,user_id')
                    ->alias('c')
                    ->join('shop_goods g','c.goods_id=g.goods_id')
                    ->where($where)
                    ->select();
                $cartInfo=$cartInfo->toArray();
                // print_r($cartInfo);die;
            foreach ($cartInfo as $k => $v) {
                
                $cartInfo[$k]['order_id']=$order_id;
                
            }
            
            $data=[];
            foreach ($cartInfo as $k => $v) {
                    // print_r($v);
                    $data[$k]['goods_id']=$v['goods_id'];
                    $data[$k]['goods_price']=$v['goods_price'];
                    $data[$k]['goods_img']=$v['goods_img'];
                    $data[$k]['user_id']=$v['user_id'];
                    $data[$k]['order_id']=$v['order_id'];
                    $data[$k]['buy_number']=$v['buy_number'];
                }
            
            // print_r($cartInfo);die;
            
            // print_r($data[]);die;
            $res2=$detail_model->saveAll($data);
            // dump($goodsInfo);die;
            if(empty($res2)){
                throw new \Exception('订单商品写入失败');
            }


            // 清除购物车数据
            $wherecart=[
                ['user_id','=',$user_id],
                ['goods_id','in',$goods_id]
            ];
            $res3=$cart_model->where($wherecart)->update(['is_del'=>2]);
            if(empty($res3)){
                throw new \Exception('清空购物车失败');
            }

            // 修改商品表库存
            $goods_model=model('goods');
            foreach ($cartInfo as $k =>$v) {
                $res4=$goods_model->where('goods_id',$v['goods_id'])->update(['goods_num'=>['dec',$v['buy_number']]]);
                if(empty($res4)){
                throw new \Exception('库存修改失败');
            }
            }
            
            // 提交
            $order_model->commit();
            echo json_encode(['font'=>'下单成功','code'=>'1','order_id'=>$order_id]);
        }catch(\Exception $e){
            echo fail($e->getmessage());
            // 回滚
            $order_model->rollback();
        }
    }
    // 获取订单号
    public function getOrderNo()
    {
        $user_id=$this->getUserId();
        return time()+rand(100,999).$user_id;
    }
    // 获取订单总金额
    public function getOrderAmount($goods_id)
    {
        $cart_model=model('Cart');
        $user_id=$this->getUserId();
        $where=[
            ['is_del','=',1],
            ['user_id','=',$user_id],
            ['c.goods_id','in',$goods_id]
        ];
        $cartInfo=$cart_model
            ->field('buy_number,goods_price')
            ->alias('c')
            ->join('shop_goods g','c.goods_id=g.goods_id')
            ->where($where)
            ->select();
        if(!empty($cartInfo)){
            // print_r($cartInfo);die;
            $count=0;
            foreach ($cartInfo as $k => $v) {
                $count+=$v['buy_number']*$v['goods_price'];
            }
            return $count;
        }else{
            return 0;
        }    
    }

    public function successOrder()
    {
        $order_id=input('get.order_id',0,'intval');
        if(empty($order_id)){
            $this->error('请选择一个订单',url('Index/index'));
        }
        $order_model=model('Order');
        $orderInfo=$order_model->find();
        $this->assign('orderInfo',$orderInfo);
        $this->getCateInfo();
        return $this->fetch();
    }
    // 异常处理
}
