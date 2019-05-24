<?php

namespace app\admin\validate;

use think\Validate;

class Friend extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'friend_name'=>['require','checkOnly'],
        'friend_url'=>['require','url']

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'friend_name.require'=>'友链名不能为空',
        'friend_url.require'=>'友链网址不能为空',
        'friend_url.url'=>'友链网址格式不正确'
    ];

    //自定义规则
    protected function checkOnly($value,$rule,$data=[]){
        if(empty($data['friend_id'])){
            $where[]=['friend_name','=',$value];
        }else{
            $where[]=['friend_name','=',$value];
            $where[]=['friend_id','<>',$data['friend_id']];
        }
        $count=db('friend')->where($where)->count();
        return $count>0 ? '友链名称以存在' : true;
    }
}
