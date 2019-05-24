<?php

namespace app\admin\validate;

use think\Validate;

class Shuo extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'shuo_name'=>['require','checkOnly']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'shuo_name.require'=>'小说名不能为空'
    ];

    //自定义验证
    public function checkOnly($value,$rule,$data=[]){
        if(empty($data['shuo_id'])){
            $where[]=['shuo_name','=',$data['shuo_name']];
        }else{
            $where[]=['shuo_name','=',$data['shuo_name']];
            $where[]=['shuo_id','<>',$data['shuo_id']];
        }
        $count=db('shuo')->where($where)->count();
        return $count;
    }
}
