<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 首页左侧的分类的无限极函数
 * @param  [type]  $cateInfo [description]
 * @param  integer $cate_pid [description]
 * @return [type]            [description]
 */
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

/**
 * 获取分类下的每一级id
 * @param  [type]  $cateInfo [description]
 * @param  integer $cate_pid [description]
 * @return [type]            [description]
 */
function getCateId($cateInfo,$cate_pid=0){
	static $id=[];
	foreach ($cateInfo as $k => $v){
		if($v['cate_pid']==$cate_pid){
			$id[]=$v['cate_id'];
			getCateId($cateInfo,$v['cate_id']);
		}
	}
	return $id;
}

//返回成功的json数据
function successly($font){
	echo json_encode(['font'=>$font,'code'=>1]);
}
//返回失败的json数据
function fail($font){
	echo json_encode(['font'=>$font,'code'=>2]);exit;
}

//生成6位验证码
function createCode(){
	return rand(100000,999999);
}

/**
 * 数组base64加密成字符串
 * @param  [type] $info [description]
 * @return [type]       [description]
 */
function createBase64Info($info){
	return base64_encode(serialize($info));
}

/**
 * 字符串base64解密
 * @param $str 
 * @return array
 */
function getBase64Info($str){
	return unserialize(base64_decode($str));
} 