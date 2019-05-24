<?php

namespace app\admin\validate;

use think\Validate;

class Brand extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'brand_name'=>['require','chsAlphaNum','checkName']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'brand_name.require'=>'品牌名称不能为空',
        'brand_name.chsAlphaNum'=>'品牌名称只能是汉字，数字，字母'
    ];

    /**
     * 自定义规则
     * 
     *
     * @var array
     */
    protected function checkName($value,$rule,$data=[]){
        if(empty($data['brand_id'])){
            $where =['brand_name'=>$value];
        }else{
            $where[] =['brand_name','=',$value];
            $where[] =['brand_id','<>',$data['brand_id']];
        }
        $count=db('Brand')->where($where)->count();
        return $count>0 ? '品牌名称以存在' : true; 
    }

}
