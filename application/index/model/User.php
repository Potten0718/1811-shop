<?php

namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $pk="user_id";
    protected $table="shop_user";

    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='create_time';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;

    protected $insert=['user_pwd'];
    protected function setUserPwdAttr($value){
    	return md5($value);
    }
}
