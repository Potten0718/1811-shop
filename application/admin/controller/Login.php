<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function login(){
    	//判断数据类型
    	if(request()->isPost() && request()->isAjax()){
    		//接收数据
    		$data=input('post.');
    		//非空验证（）
    		//验证数据（1验证验证码、2验证用户名、3验证密码）
    		if(!captcha_check($data['admin_code'])){
    			echo json_encode(['content'=>'验证码错误','icon'=>2,'code'=>2]);die;
    		}

    		//验证用户名是否存在
    		$admin=db('Admin')->where(['admin_name'=>$data['admin_name'],'admin_status'=>1])->find();
    		if(!$admin){
    			echo json_encode(['content'=>'用户名不存在','icon'=>2,'code'=>2]);die;
    		}

    		//验证密码是否正确
    		$admin_pwd=createPwd($data['admin_pwd'],$admin['admin_salt']);
    		// dump($admin_pwd);die;
    		if($admin_pwd != $admin['admin_pwd']){

    			echo json_encode(['content'=>'用户密码不对','icon'=>2,'code'=>2]);
    		}else{
    			//密码匹配 将用户相关信息存贮到session里面
    			session('info',['admin_id'=>$admin['admin_id'],'admin_name'=>$admin['admin_name']]);
    			//修改用户登陆时间及ip地址
    			$time=time();
    			$ip=request()->ip();
    			db('Admin')->where(['admin_id'=>$admin['admin_id']])->update(['last_login_time'=>$time,'last_login_ip'=>$ip]);
    			//返回登陆是否成功
    			echo json_encode(['content'=>'登陆成功','icon'=>1,'code'=>1]);	
    		}
    	}else{
    			//模板布局  清除模板
		    	$this->view->engine->layout(false);
		    	return $this->fetch();
    	}

    	
    }

    public function loginOut(){
    	session('info',null);
    	$this->success('退出	成功','Login/login');
    }
}
