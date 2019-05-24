<?php /*a:1:{s:70:"D:\lening\PHPTutorial\WWW\shop\application\index\view\goods\goods.html";i:1554885533;}*/ ?>
    <ul class="cate_list">
                    <?php if(is_array($goodsInfo) || $goodsInfo instanceof \think\Collection || $goodsInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $goodsInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li>
                        <div class="img">
                            <a href="<?php echo url('Goods/goodsDetail'); ?>?goods_id=<?php echo htmlentities($vo['goods_id']); ?>">
                                <img src="<?php echo htmlentities($vo['goods_img']); ?>" width="210" height="185" /></a>
                            </div>
                        <div class="price">
                            <font>￥<span><?php echo htmlentities($vo['goods_price']); ?></span></font>
                        </div>
                        <div class="name"><a href="<?php echo url('Goods/goodsDetail'); ?>?goods_id=<?php echo htmlentities($vo['goods_id']); ?>"><?php echo htmlentities($vo['goods_name']); ?></a></div>
                        <div class="carbg">
                            <a href="#" class="ss">收藏</a>
                            <a href="#" class="j_car">加入购物车</a>
                        </div>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                
                <div class="pages">
                   <?php echo $str; ?>
                </div>