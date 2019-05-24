<?php

namespace app\admin\validate;

use think\Validate;

class user extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'admin_name'=>['require','chs','length:2,5','checkName'],
        'admin_pwd'=>['require','alphaDash','min:3'],
        'admin_repwd'=>['confirm:admin_pwd'],
        'admin_tel'=>['require','checkTel']
        // 'admin_email'=>['require','eamil']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'admin_name.require'=>'用户名不能为空',
        'admin_name.chs'=>'用户名必须为中文',
        'admin_name.length:2,5'=>'用户名长度为2~5个汉字',
        'admin_pwd.require'=>'密码不能为空',
        'admin_pwd.alphaDash'=>'密码必须由数字、字母、下划线、破折号组成',
        'admin_pwd.min:3'=>'密码不能小于三位',
        'admin_repwd.confirm'=>'两次密码不一致',
        // 'admin_email.require'=>'email不能为空',
        // 'admin_email.email'=>'邮箱不符合规则'
    ];

   /**
     * 自定义验证规则
     * $value：被验证的数据 $rule: 
     * $data:全部数据
     * @var array
     */ 
    protected function checkTel($value,$rule,$data=[]){
        $reg= '/^1\d{10}$/';
        if(!preg_match($reg,$value)){
            return "电话号必须以1开头的11位纯数字";
        }else{
            if(empty($data['admin_id'])){
                $where[]=['admin_tel','=',$value];
            }else{
                $where[]=['admin_tel','=',$value];
                $where[]=['admin_id','<>',$data['admin_id']];
            }
            $count=db('admin')->where($where)->count();
            return $count ? '电话已存在' : true;
        }
    }

    protected function checkName($value,$rule,$data=[]){
        if(empty($data['admin_id'])){
            $where[]=['admin_name','=',$value];
        }else{
            $where[]=['admin_name','=',$value];
            $where[]=['admin_id','<>',$data['admin_id']];
        }
        $count=db('admin')->where($where)->count();
        return $count ? '用户名已存在' : true;
    }

        /**
     * 定义验证场景
     * 格式：'场景名称' =>  ['字段1','字段2']
     *
     * @var array
     */ 
    protected $scene = [
        'update' => ['admin_name','admin_tel','admin_email'],
    ];
}
