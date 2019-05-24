<?php /*a:2:{s:70:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\goods\index.html";i:1553603404;s:65:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\layout.html";i:1554108201;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>layout 后台大布局 - Layui</title>
  <link rel="stylesheet" href="/static/layui/css/layui.css">
  <script src="/static/layui/layui.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">layui 后台布局</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="/static/123.jpg" class="layui-nav-img">
          <?php echo htmlentities(app('session')->get('info.admin_name')); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="<?php echo url('admin/updatePass'); ?>">修改密码</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="<?php echo url('login/loginOut'); ?>">退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">用户管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/create'); ?>">用户添加</a></dd>
            <dd><a href="<?php echo url('admin/index'); ?>">用户列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a class="" href="javascript:;">分类管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('category/create'); ?>">分类添加</a></dd>
            <dd><a href="<?php echo url('category/index'); ?>">分类列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">品牌管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('brand/create'); ?>">品牌管理</a></dd>
            <dd><a href="<?php echo url('brand/index'); ?>">品牌列表</a></dd>
          </dl>
        </li>
          <li class="layui-nav-item">
          <a href="javascript:;">商品管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('goods/create'); ?>">商品添加</a></dd>
            <dd><a href="<?php echo url('goods/index'); ?>">商品列表</a></dd>
            <dd><a href="<?php echo url('goods/recycle'); ?>">商品回收站</a></dd>
          </dl>
        </li>
         <li class="layui-nav-item">
          <a href="javascript:;">公告管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('gonggao/create'); ?>">公告添加</a></dd>
            <dd><a href="<?php echo url('gonggao/index'); ?>">公告列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">友链管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('friend/create'); ?>">友链添加</a></dd>
            <dd><a href="<?php echo url('friend/index'); ?>">友链列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">小说管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('shuo/create'); ?>">小说添加</a></dd>
            <dd><a href="<?php echo url('shuo/index'); ?>">小说列表</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <form class="layui-form" >
	<div class="layui-form-item">
		<div class="layui-form-inline">
			<select  name="cate_id" id="">
				<option value="">请选择分类信息</option>
				<?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo htmlentities($c['cate_id']); ?>"><?php echo str_repeat('--',$c['level']); ?><?php echo htmlentities($c['cate_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<div class="layui-input-inline">
			<select name="brand_id" id="">
				<option value="">请选择品牌信息</option>
				<?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo htmlentities($b['brand_id']); ?>"><?php echo htmlentities($b['brand_name']); ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
	     	<div class="layui-input-inline">
				<input type="text" name="goods_name" placeholder="请输入商品名称" class="layui-input" >
			</div>
			<div class="layui-input-inline">
				<button class="layui-btn">搜索</button>
		</div>
	</div>
</form>
<table class="layui-table">
<thead>
    <tr>
        <th><input type="checkbox" id="ck"></th>
        <th>名称</th>
        <th>价格</th>
        <th>上架</th>
        <th>新品</th>
        <th>精品</th>
        <th>热卖</th>
        <th>库存</th>
        <th>积分</th>
        <th>分类</th>
        <th>品牌</th>
        <th>单图片</th>
        <th>多图片</th>
        <th>操作</th>
    </tr>
</thead>
<tbody>
    <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><input type="checkbox" name="goods_id" value="<?php echo htmlentities($vo['goods_id']); ?>"></td>
        <td class="goods_name"><?php echo substr($vo['goods_name'],0,30); ?></td>
        <td><?php echo htmlentities($vo['goods_price']); ?></td>
        <td><?php echo htmlentities($vo['goods_up']); ?></td>
        <td><?php echo htmlentities($vo['goods_new']); ?></td>
        <td><?php echo htmlentities($vo['goods_best']); ?></td>
        <td><?php echo htmlentities($vo['goods_hot']); ?></td>
        <td><?php echo htmlentities($vo['goods_num']); ?></td>
        <td><?php echo htmlentities($vo['goods_score']); ?></td>
        <td><?php echo htmlentities($vo['cate']['cate_name']); ?></td>
        <td><?php echo htmlentities($vo['brand']['brand_name']); ?></td>
        <td><img src="<?php echo htmlentities($vo['goods_img']); ?>" width="100" alt="暂无图片"></td>
        <td width="110">
            <?php foreach($vo['goods_simg'] as $k=>$v): ?>
            <img src="<?php echo htmlentities($v); ?>"  width="50" alt="暂无图片">
            <?php endforeach; ?>
        </td>
        <td>
            [<a href="<?php echo url('goods/edit',['goods_id'=>$vo['goods_id']]); ?>">编辑</a>]
            [<a href="<?php echo url('goods/delete',['goods_id'=>$vo['goods_id']]); ?>">删除</a>]
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</tbody>
</table>
<button id="fx" class="layui-btn-sm layui-btn-primary">
	<i class="layui-icon">反选</i>
</button>
<button id="del" class="layui-btn layui-btn-sm layui-btn-primary">
	<i class="layui-icon">批量删除</i>
</button>
<script type="text/javascript">
//商品名称即点即改
layui.use(['form','jquery','layer'],function(){
	var $ = layui.jquery, layer = layui.layer;
	//通过类选择器，查找商品名称id,为其添加点击事件
	$('.goods_name').click(function(){
		var _this=$(this);
		//判断td中input元素的个数，如果大于0，证明以存在input
		if(_this.children('input').length>0){
			return false;
		};
		//获取商品名称
		var goods_text = _this.text();
		//清空td
		_this.empty();
		//创建input元素，更改input样式，将原商品名称赋值给input
		var ipt = $('<input type="text" />').css({'border-width':'0','background-color':_this.css('background-color')}).val(goods_text);
		//将创建好的input元素，追加到td中
		_this.append(ipt);
		//让input元素获取焦点，并选取内容
		ipt.focus().select();
		//用户修改数据
		//为input元素添加键盘事件
		ipt.keyup(function(e){
			//获取用户点击的案件编码
			var keyCode=e.which;
			//判断用户点击的是enter还是esc
			if(keyCode==13){
				//发送ajax请求，修改数据库数据
				$.post(
					"<?php echo url('goods/editGoodsName'); ?>",
					{goods_id: _this.prev('td').children('input').val(),goods_name: ipt.val()},
					function(data){
						layer.msg(data.content,{icon:data.icon,time:1000},function(){
							//如果data.code==1 证明数据修改成功 ，清空td,将新值添加到非表单元素td中
							if(data.code==1){
								_this.empty().text(ipt.val());
							}else{
								//如果修改失败，数据还原
								_this.text(goods_text);
							}
						});
					},
					'json'
					);
			}else if(keyCode==27){
				//数据还原
				_this.empty();
				_this.text(goods_text);
			}
		});
		//为input元素添加焦点失去事件
		ipt.blur(function(){
			//数据还原
			_this.empty();
			_this.text(goods_text);
		});
	});

	//全选、全不选
	$('#ck').click(function(){
		if($(this).prop('checked')){
			$(':checkbox').prop('checked',true);
		}else{
			$(':checkbox').prop('checked',false);
		}
	});

	//反选
	$('#fx').click(function(){
		$(':checkbox:gt(0)').each(function(){
			if($(this).prop('checked')){
				$(this).prop('checked',false);
			}else{
				$(this).prop('checked',true);
			}
		});
	});	

	//批量删除
	$('#del').click(function(){
		var ids=[];
		$(':checkbox').each(function(){
			if($(this).prop('checked')){
				//向数组ids末尾添加数组元素(值为被选中的复选框的值)
				ids.push($(this).val());
			}
		});
		$.post(
			"<?php echo url('goods/dels'); ?>",
			{goods_id:ids},
			function(msg){
				layer.msg(msg.content,{icon:msg.icon,time:1000},function(){
						if(msg.code==1){
							history.go(0);
						};
				});
			},
			'json'
		);
	});	

});
</script>
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
  
});
</script>
</body>
</html>