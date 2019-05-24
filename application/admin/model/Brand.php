<?php

namespace app\admin\model;

use think\Model;

class Brand extends Model
{
    protected $pk='brand_id';
    //开启自动写入时间戳
    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='brand_time';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;


     //是否显示 获取器
    public function getBrandShowAttr($value){
    	$cate_show=['否','是'];
    	return $cate_show[$value];
    }

    //是否显示 修改器
    public function setBrandShowAttr($value){
    	$cate_show=['是'=>1,'否'=>0];
    	return $cate_show[$value];
    }

}
