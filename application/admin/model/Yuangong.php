<?php

namespace app\admin\model;

use think\Model;

class Yuangong extends Model
{
    protected $pk="yg_id";

    // //是否显示 获取器
    // public function getYuanggongSexAttr($value){
    // 	$yg_sex=['男','女'];
    // 	return $yg_sex[$value];
    // }

    // //是否显示 修改器
    // public function setYuangongSexAttr($value){
    // 	$yg_sex=['男'=>1,'女'=>0];
    // 	return $yg_sex[$value];
    // }
}
