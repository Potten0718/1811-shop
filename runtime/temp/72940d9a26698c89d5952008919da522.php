<?php /*a:1:{s:68:"D:\lening\PHPTutorial\WWW\shop\application\index\view\index\div.html";i:1554964387;}*/ ?>
 <div cate_id="<?php echo htmlentities($floorInfo['topInfo']['cate_id']); ?>"> 
    <div class="i_t mar_10">
        <span class="floor_num"><?php echo htmlentities($floor_num); ?>F</span>
        <span class="fl"><?php echo htmlentities($floorInfo['topInfo']['cate_name']); ?></span>                
        <span class="i_mores fr">
            <?php if(is_array($floorInfo['secondInfo']) || $floorInfo['secondInfo'] instanceof \think\Collection || $floorInfo['secondInfo'] instanceof \think\Paginator): $i = 0; $__LIST__ = $floorInfo['secondInfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <a href="#"></a><?php echo htmlentities($v['cate_name']); ?></span>
            <?php endforeach; endif; else: echo "" ;endif; ?>
    </div> 
    <div class="content">

        <div class="fresh_mid">
            <ul>
                <?php if(is_array($floorInfo['goodsInfo']) || $floorInfo['goodsInfo'] instanceof \think\Collection || $floorInfo['goodsInfo'] instanceof \think\Paginator): $i = 0; $__LIST__ = $floorInfo['goodsInfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <div class="name"><a href="<?php echo url('Goods/goodsDetail'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><?php echo htmlentities($v['goods_name']); ?></a></div>
                    <div class="price">
                        <font>￥<span><?php echo htmlentities($v['goods_price']); ?></span></font> &nbsp; <?php echo htmlentities($v['goods_score']); ?>
                    </div>
                    <div class="img"><a href="<?php echo url('Goods/goodsDetail'); ?>?goods_id=<?php echo htmlentities($v['goods_id']); ?>"><img src="<?php echo htmlentities($v['goods_img']); ?>" width="185" height="155" /></a></div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                                                
            </ul>
        </div>

    </div>   
   </div>