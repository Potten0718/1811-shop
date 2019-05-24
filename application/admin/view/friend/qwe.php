<?php

//无限极分类
function getCateInfo($cateInfo,$pid){
	static $info=[];
	foreach($cateInfo as $k=>$v){
		if($v['pid']==$pis){
			$info[]=$v;
			getCateInfo($cateInfo,$pid);
		}
	}
	return $info;
}


public function checkOnly(){
	$friend_name=input('post.feiend_name');
	$friend_id=input('post.feiend_id');
	if(empty($friend_id)){
		$where[]=['frend_name','=',$friend_name];
	}else{
		$where[]=['friend_name','=',$friend_name];
		$where[]=['friend_id','<>',$friend_id];
	}
	$count=db('friend')->where($where)->count();
	return $count;
}

public function save(Request $request){
	if(request()->isPost && request()->isAjax()){
		$data=input('post');
		$validate=validate('Friend');
		if(!$valiate->check($data)){
			$content=$validata->getError();
			echo json_encode(['content'=>$content,'icon'=>2,'code'=>2]);exit;
		}
		$res=model('Friend')->save($data);
		if($res){
			echo json_encode(['conetnt'=>'添加成功','icon'=>1,'code'=>1]);
		}else{
			echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
		}

	}

	public function checkOnly($value,$rule,$data=[]){
		if(empty($data['frined_id'])){
			$where[]=['friend_name','=',$value];
		}else{
			$where[]=['friend_name','=',$value];
			$where[]=['friend_id','<>',$data['frined_id']];
		}
		$count=db('friend')->where($where)->count();
		return $count ?'友链名称已经存在' :true;
	}
}
?>