<?php

namespace app\admin\validate;

use think\Validate;

class Gonggao extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'gong_title'=>['require','checkOnly']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'gong_title.require'=>'公告名不能为空'
    ];

    //自定义规则
    public function checkOnly($value,$rule,$data=[]){
        if(empty($data['gong_id'])){
            $where[]=['gong_title','=',$value];
        }else{
            $where[]=['gong_title','=',$value];
            $where[]=['gong_id','<>',$data['gong_id']];
        }
        $count=db('gonggao')->where($where)->count();
        return $count ? '标题名以存在' : true;
    }
}
