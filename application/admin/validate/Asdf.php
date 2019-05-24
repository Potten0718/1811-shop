<?php

namespace app\admin\validate;

use think\Validate;

class Asdf extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'asdf_name'=>['require','checkName'],
        'asdf_tel'=>['require','checkTel']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [ 
        'asdf_name.require'=>'名態为空'
        'asdf_tel.require'=>'电话不能为空'
    ];

    public function checkName($value,$rule,$data=[]){
        if(empty($data['asdf_id'])){
            $where[]=['asdf_name','=',$value];
        }else{
            $where[]=['asdf_name','=',$value];
            $where[]=['asdf_id','<>',$data['asdf_id']];
        }
        $count=model("Asdf")->where($where)->count();
        return $count>0 ?"用户名已存在": ture;
    } 
}
