<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    protected $pk='admin_id';
    //开启自动写入时间戳
    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='admin_create';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;


    //状态 修改器
    // public function setAdminStatusAttr($value){
    // 	return empty($value)?0:1;
    // }
    //状态 获取器
    public function getAdminStatusAttr($value){
    	$admin_status=['关闭','开启'];
    	return $admin_status[$value];
    }

    // 状态 数据完成
    protected $auto=['admin_status','admin_salt','admin_pwd'];
    protected function setAdminStatusAttr($value){
    	return empty($value)?0:1;
    } 
    

    //储存生成的盐
    public $salt;
    //密码 数据完成
    protected function setAdminPwdAttr($value){
        $this->salt=createSalt();
        $admin_pwd=createPwd($value,$this->salt);
        return $admin_pwd;
    }

    //盐 数据完成
    protected function setAdminSaltAttr($value){
        return $this->salt;
    }
}
