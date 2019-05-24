<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\controller\Common;
class Index extends Common
{
    public function index(){
    	//调用视图文件
    	return $this->fetch();
    }
}
