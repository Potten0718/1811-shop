<?php

namespace app\admin\model;

use think\Model;

class Shuo extends Model
{
    protected $table='shop_shuo';
     protected $pk='shuo_id';
    //开启自动写入时间戳
    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='create_time';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;

   
    protected function getShuoStatusAttr($value){
        $shuo_status=['关闭','开启'];
        return $shuo_status[$value];
    }
    protected function setShuoStatusAttr($value){
        $shuo_status=['开启'=>1,'关闭'=>0];
        return $shuo_status[$value];
    } 
    



}
