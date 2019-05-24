<?php

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'goods_name'=>['require'],
        'goods_price'=>['require','float'],
        'goods_mprice'=>['require','float'],
        'goods_num'=>['require','number'],
        'goods_score'=>['require','number']
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'goods_name.require'=>'商品名不能为空',
        'goods_price.require'=>'商品价格不能为空',
        'goods_name.float'=>'商品价格必须为数值',
        'goods_mprice.require'=>'市场价格不能为空',
        'goods_mprice.float'=>'市场价格必须为数值',
        'goods_num.require'=>'库存量不能为空',
        'goods_num.number'=>'库存量不许为纯数字',
        'goods_score.require'=>'商品积分必填',
        'goods_score.number'=>'商品积分必须为纯数字'
    ];
}
