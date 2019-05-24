<?php

namespace app\index\controller;

use think\Controller;

class Goods extends Common
{
    //商品列表
    public function goodsList()
    {
        $cate_id=input('get.cate_id',0,'intval');
        // dump($cate_id);die;
        if(empty($cate_id)){
            $where=[];
            session('cate_id',null);
        }else{
            //获取当前分类下所有子类cate_id
            $cate_model=model('Category');
            $info=$cate_model->where('cate_show',1)->select();
            $cate_id=getCateId($info,$cate_id);
            session('cate_id',$cate_id);
            $where=[
                ['cate_id','in',$cate_id]
            ];
        }
        //获取品牌信息
        $goods_model=model('Goods');
        //colum:查询一列数据
        $brand_id=$goods_model->where($where)->column('brand_id');
        $brand_id=array_unique($brand_id);
        $brand_model=model('Brand');
        $brandWhere=[
            ['brand_id','in',$brand_id]
        ];
        $brandInfo=$brand_model->field('brand_id,brand_name')->where($brandWhere)->select();
        //获取价格区间
        $goods_price=$goods_model->where($where)->order("goods_price",'desc')->limit(1)->value('goods_price');
        $priceInfo=$this->getPriceSectior($goods_price);
        
        //获取商品数据+分页
        $goodsInfo=$goods_model->where($where)->limit(4)->select();
        $obj=new \page\AjaxPage();
        $p=1;
        $page_num=4;
        $count=$goods_model->where($where)->count();
        $str=$obj->ajaxpager(1,30,4);

        //获取浏览历史的数据
        if($this->checkLogin()){
            $historyInfo=$this->getHistoryInfoDb();
        }else{
             $historyInfo=$this->getHistoryInfoCookie();
        }
        

        $this->assign('brandInfo',$brandInfo);
        $this->assign('priceInfo',$priceInfo);
        $this->assign('goodsInfo',$goodsInfo);
        $this->assign('historyInfo',$historyInfo);
        $this->assign('str',$str); //实体
    	$this->getCateInfo();
    	return $this->fetch();
    }

    //从数据库中获取浏览历史记录
    public  function getHistoryInfoDb(){
        $history_model=model('History');
        $user_id=$this->getUserId();
        $goods_id=$history_model->where('user_id',$user_id)->order('look_time','desc')->column('goods_id');
        $goods_id=array_slice(array_unique($goods_id),0,4);
        $goodsInfo=$this->getHistoryInfo($goods_id);
        if(!empty($goodsInfo)){
            return $goodsInfo;
        }else{
            return false;
        }    
    }

    //从cookie中获取浏览历史记录
    public function getHistoryInfoCookie(){
        $str=cookie('historyInfo');
        if(!empty($str)){
            //解密
            $info=getBase64Info($str);
            $info=array_reverse($info);
            $goods_id=[];
            foreach($info as $k=>$v){
                $goods_id[]=$v['goods_id'];
            }
            $goods_id=array_slice(array_unique($goods_id),0,4);
            $goodsInfo=$this->getHistoryInfo($goods_id);
            if(!empty($goodsInfo)){
                return $goodsInfo;
            }else{
                return false;
            }
        }
    }

    //获取浏览历史的商品数据
    public function getHistoryInfo($goods_id){
        //查询数据必须按照指定的商品id顺序查询
        $g_id=implode(',',$goods_id);
        $where=[
            ['goods_id','in',$goods_id]
        ];
        $exp=new \think\db\Expression("field(goods_id,$g_id)");
        $goodsInfo=model('Goods')->where($where)->order($exp)->select();
        // echo model('Goods')->getLastSql();exit;
        // dump($goodsInfo);
        return $goodsInfo;
    }

    //商品详情
    public function goodsDetail(){
        //接收商品id
        $goods_id=input('get.goods_id',0,'intval');
        if(empty($goods_id)){
            $this->error("请选择一件商品");exit;
        }
        //根据id查询一条数据
        $goods_model=model('Goods');
        $goodsInfo=$goods_model->where('goods_id',$goods_id)->find();

        //存入浏览记录
        if($this->checkLogin()){
            //把浏览记录信息存入数据库
            $this->saveHistoryDb($goods_id);
        }else{  
            //把浏览记录信息存入cookie
            $this->saveHistoryCookie($goods_id);
        }

        
    	$this->getCateInfo();
        $this->assign('goodsInfo',$goodsInfo);
    	return view();
    }

    //获取商品价格区间
    public function getPriceSectior($max_price){
        //分成7个区间
        $price=$max_price/7;
        $priceInfo=[];
        for($i=0;$i<=6;$i++){
            $start=$i*$price;
            $end=$price*($i+1)-0.01;
            $priceInfo[]=number_format($start,2)."-".number_format($end,2);
        }
        $priceInfo[]=$end."及以上";
        return $priceInfo;
    }

    //重新获取价格
    public function getPriceInfo(){
        $brand_id=input('post.brand_id',0,'intval');
        $where=[
            ['brand_id','=',$brand_id]
        ];  
        if(session("?cate_id")){
            $cate_id=session('cate_id');
            $where[]=['cate_id','in',$cate_id];
        }
        $goods_model=model("Goods");
        $goods_price=$goods_model->where($where)->order("goods_price","desc")->limit(1)->value('goods_price');
        $priceInfo=$this->getPriceSectior($goods_price);
        echo json_encode($priceInfo);
    }

    //获取商品数据
    public function getGoodsInfo(){
        //获取数据
        $brand_id=input('post.brand_id',0,'intval');
        $price=input('post.price','');
        $order_field=input('post.order_field','');
        $order_type=input('post.order_type','');
        $field=input('post.field','');
        $p=input('post.p',1);
        $where=[];
        //处理条件
        if(session('?cate_id')){
            $cate_id=session('cate_id');
            $where[]=['cate_id','in',$cate_id];
        }
        //
        if(!empty($brand_id)){
            $where[]=['brand_id','=',$brand_id];
        }

        if(!empty($price)){
            //检测-是否存在
            if(strpos($price,'-')){
                $price=explode('-',$price);
                $one=str_replace(',','',$price[0]);
                $two=str_replace(',','',$price[1]);
                $where[]=['goods_price','>=',$one];
                $where[]=['goods_price','<=',$two];
            }else{
                (int)$price;
                $where[]=['goods_price','>=',$price];
            }            
        }

        if(!empty($field)){
            $where[]=[$field,'=',1];
        }

        //查询数据
        $goods_model=model('Goods');
        if(empty($order_field)){
            $goodsInfo=$goods_model->where($where)->page($p,4)->select();
        }else{
            $goodsInfo=$goods_model->where($where)->order($order_field,$order_type)->page($p,4)->select();
        }
        // echo $goods_model->getLastSql();die;//打印左后一条sql语句
        //获取页码
        $obj=new \page\AjaxPage();
        $page_num=4;
        $count=$goods_model->where($where)->count();
        $str=$obj->ajaxpager(1,$count,$page_num);

        $this->view->engine->layout(false);
        $this->assign('goodsInfo',$goodsInfo);
        $this->assign('str',$str);
        echo $this->fetch('goods');
    }

    /**浏览记录历史存入数据库
     * [saveHistoryDb description]
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    public function saveHistoryDb($goods_id){
        $info=[
            'goods_id'=>$goods_id,
            'look_time'=>time(),
            'user_id'=>$this->getUserId()
        ];
        $history_model=model('History');
        $history_model->save($info);
    }

    /**把浏览记录信息存入cookie
     * [saveHistoryCookie description]
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    public function saveHistoryCookie($goods_id){
        //判断cookie里是否有数据
        $history_str=cookie('historyInfo');
        if(!empty($history_str)){
            $info=getBase64Info($history_str);
            if(strlen($history_str)>4000){
                array_shift($info);
            }
            // dump($info);exit;
            $info[]=[
                'goods_id'=>$goods_id,
                'look_time'=>time()
            ];
        }else{
            $info=[
            [
                'goods_id'=>$goods_id,
                'look_time'=>time()
            ]
        ];
        }
        $str=createBase64Info($info);
        // dump($str);exit;
        cookie('historyInfo',$str); 
        
    } 

    //测试cookie中的数据
    public function test(){
        $str=cookie('historyInfo');
        $info=unserialize(base64_decode($str));
        dump($info);exit;
    }
}
