<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'user_email'=>['require','email','checkOnly'],
        'user_pwd'=>['require','alphaDash'],
        'user_pwd1'=>['require','confirm:user_pwd']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'user_email.require'=>'邮箱不能为空',
        'user_email.email'=>'邮箱格式不正确',
        'user_pwd.require'=>'密码不能为空',
        'user_pwd1.confirm'=>'两次密码不能一致'
    ];

    //自定义验证规则，验证邮箱唯一性
    protected function checkOnly($value,$rule,$data=[]){
        $count=db('user')->where(['user_email'=>$value])->count();
        return $count ? '邮箱以被注册，请重新输入' : true;
    }
    //自定义验证规则 是否用当前的邮箱发送的验证码
    // protected function checkEmail($value,$rule,$data=[]){

    // }
}
