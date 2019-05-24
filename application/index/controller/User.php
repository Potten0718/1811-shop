<?php

namespace app\index\controller;

use think\Controller;

class User extends Common
{
	//防非法登陆
	public function __construct(){
		parent::__construct();
		if(!$this->checkLogin()){
			$this->error('请先登陆！');
		}
	}
	
    //个人中心首页
    public function index(){
    	 // $this->view->engine->layout(false);
    	return view();
    }
}
