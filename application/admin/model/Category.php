<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
	//模型操作的表
	protected $table='shop_category';
    protected $pk='cate_id';
    //开启自动写入时间戳
    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='cate_time';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;

    //是否显示 获取器
    public function getCateShowAttr($value){
    	$cate_show=['否','是'];
    	return $cate_show[$value];
    }

    //是否显示 修改器
    public function setCateShowAttr($value){
    	$cate_show=['是'=>1,'否'=>0];
    	return $cate_show[$value];
    }

    //导航栏是否显示 获取器
    public function getCateNavAttr($value){
    	$cate_nav=['否','是'];
    	return $cate_nav[$value];
    }

    //导航栏是否显示 修改器
    public function setCateNavAttr($value){
    	$cate_nav=['是'=>1,'否'=>0];
    	return $cate_nav[$value];
    }

}
