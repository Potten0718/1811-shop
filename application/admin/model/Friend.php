<?php

namespace app\admin\model;

use think\Model;

class Friend extends Model
{
	protected $table='shop_friend';
    protected $pk='friend_id';
    //开启自动写入时间戳
    protected $autoWriteTimestamp ='true';
    //定义时间戳字段名
    protected $createTime='friend_add_time';
    //关闭自动写入update_time时间戳
    protected $updateTime=false;

}
