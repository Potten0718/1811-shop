<?php

namespace app\admin\model;

use think\Model;

class Gonggao extends Model
{
    protected $pk='gong_id';
    protected $table='shop_gonggao';
    protected $autoWriteTimestamp =true;
    protected $createTime ='release_time';
    protected $updateTime =false;

    //获取器
    public function getReleaseStatusAttr($value){
    	$release_status=['否','是'];
    	return $release_status[$value];
    }
    //修改器
    public function setReleaseStatusAttr($value){
    	$release_status=['是'=>1,'否'=>0];
    	return $release_status[$value];
    }
}
