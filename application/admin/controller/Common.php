<?php

namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
    
    protected function initialize(){
    	if(!session('?info')){
    		$this->error('爸爸！请重新登陆','Login/login');
    	}
    }

}
