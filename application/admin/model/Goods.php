<?php

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

class Goods extends Model
{
     protected $pk='goods_id';
     protected $table='shop_goods';

     use SoftDelete;
     protected $deleteTime='delete_time';

     //是否上架 修改器
     protected function setGoodsUPAttr($value){
     	$goods_up=['是'=>1,'否'=>0];
     	return $goods_up[$value];
     } 
     //是否上架 获取器
     protected function getGoodsUpAttr($value){
     	$goods_up=['否','是'];
     	return $goods_up[$value];
     }

     //商品的 新品、精品、热卖的 数据完成(写入： 新增、修改)
     protected $auto=['goods_new','goods_best','goods_hot'];
     //新品的数据完成
     protected function setGoodsNewAttr($value){
     	return empty($value) ? 0 :1;
     }
     protected function getGoodsNewAttr($value){
     	return $value ? '是' : '否';
     }
     //精品的数据完成
     protected function setGoodsBestAttr($value){
     	return empty($value) ? 0 :1;
     }
     protected function getGoodsBestAttr($value){
     	return $value ? '是' : "否";  
     }
     //热度的数据完成
     protected function setGoodsHotAttr($value){
     	return empty($value) ? 0 : 1; 
     }
     protected function getGoodsHotAttr($value){
     	return $value ? '是' : '否';
     }
     
     //多对一关联 （方法名自定义，在遍历goods表数据时，使用该方法名作为动态属性去获取关联模型中的数据） 
     public function cate(){
          //belongTo('要关联的模型'，'当前模型的关联字段'，'要关联的模型的主键')
          return $this->belongsTo('Category','cate_id','cate_id');
     } 
     public function brand(){
          return $this->belongsTo('Brand','brand_id','brand_id');
     }

     //图片获取器
     public function getGoodsSimgAttr($value){
          return explode('|',ltrim($value,'|'));
     }
     public function getGoodsMimgAttr($value){
          return explode('|',ltrim($value,'|'));
     }
     public function getGoodsBimgAttr($value){
          return explode('|',ltrim($value,'|'));
     }
}
