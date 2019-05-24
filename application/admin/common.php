<?php
//生成盐值
function createSalt(){
	return uniqid();
}

//生成密码
function createPwd($pwd,$salt){
	return md5(md5($pwd).md5($salt));
}

//无限极分类（递归）
function getCateInfo($data,$cate_pid=0,$level=0){
  //用于存储整理后的数据
	static $arr=[];
	//遍历整个数组
	foreach($data as $k=>$v){
		if($v['cate_pid']==$cate_pid){
		    $v['level']=$level;
		    $arr[]=$v;
			getCateInfo($data,$v['cate_id'],$level+1);
		    	}
		   }
	return $arr;
}

function getShuoInfo($data,$shuo_pid=0,$level=0){
  //用于存储整理后的数据
	static $arr=[];
	//遍历整个数组
	foreach($data as $k=>$v){
		if($v['shuo_pid']==$shuo_pid){
		    $v['level']=$level;
		    $arr[]=$v;
			getShuoInfo($data,$v['shuo_id'],$level+1);
		    	}
		   }
	return $arr;
}

//在windows下解析为\ 在Linux下解析为/
define('DS',DIRECTORY_SEPARATOR);
?>