<?php /*a:1:{s:73:"D:\lening\PHPTutorial\WWW\shop\application\index\view\login\register.html";i:1554961748;}*/ ?>
<!DOCTYPE html>
<html>

	<head lang="en">
		<meta charset="UTF-8">
		<title>注册</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<meta name="renderer" content="webkit">
		<meta http-equiv="Cache-Control" content="no-siteapp" />

		<link rel="stylesheet" href="/static/index/login/amazeui.css" />
		<link href="/static/index/login/dlstyle.css" rel="stylesheet" type="text/css">
		<link href="/static/layui/css/layui.css" rel="stylesheet" type="text/css">

		<script src="/static/layui/layui.js"></script>
		<script src="/static/index/login/jquery-3.2.1.min.js"></script>
		<script src="/static/index/login/amazeui.min.js"></script>

	</head>

	<body>

		<div class="login-boxtitle">
			<a href="home/demo.html"><img alt="" src="/static/index/login/logobig.png" /></a>
		</div>

		<div class="res-banner">
			<div class="res-main">
				<div class="login-banner-bg"><span></span><img src="/static/index/login/big.jpg" /></div>
				<div class="login-box">

						<div class="am-tabs" id="doc-my-tabs">
							<ul class="am-tabs-nav am-nav am-nav-tabs am-nav-justify">
								<li class="am-active"><a href="">邮箱注册</a></li>
								<li><a href="">手机号注册</a></li>
							</ul>

							<div class="am-tabs-bd">
								<!--邮箱注册-->
								<div class="am-tab-panel am-active">
									<form method="post" class="layui-form">

										<div class="user-email">
											<label for="email"><i class="am-icon-envelope-o"></i></label>
											<input type="email" name="user_email"  id="email"  lay-verify="required|email" autocomplete="off" placeholder="请输入邮箱账号">
										</div>
										<div class="verification">
											<label for="email_code"><i class="am-icon-code-fork"></i></label>
											<input type="text" name="user_code" id="email_code"  lay-verify="required" placeholder="请输入验证码">
											<a class="btn" href="javascript:void(0);"  id="sendEmailCode">
												<span class="dyButton" id="span_email">获取</span>
											</a>
										</div>
										<div class="user-pass">
											<label for="email_pwd"><i class="am-icon-lock"></i></label>
											<input type="password" name="user_pwd" id="email_pwd" lay-verify="required|checkpwd1" placeholder="设置密码">
										</div>
										<div class="user-pass">
											<label for="email_pwd1"><i class="am-icon-lock"></i></label>
											<input type="password" name="user_pwd1" id="email_pwd1" lay-verify="required|checkpwd2"  placeholder="确认密码">
										</div>
										<div class="am-cf">
											<input type="button" lay-submit lay-filter="eamailDemo" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
										</div>
									</form>

<script type="text/javascript">
	layui.use(['form','layer'],function(){
		var form =layui.form, layer=layui.layer;
		
		form.verify({
			checkpwd1:function(value){
				var reg =/^\w{2,10}$/;
				if(!reg.test(value)){
					return "密码必须为2~10为单词字符";
				};
			},
			checkpwd2:function(value){
				var user_pwd=$('#email_pwd').val();
				if(user_pwd != value){
					return "两次密码不一致";
				}
			}
		});

	//为获取按钮添加点击事件
	$('#span_email').click(function(){
		//获取邮箱地址
		var user_email=$('#email').val();
		console.log(user_email);
		if(user_email==''){
			layer.msg('邮箱地址不能为空',{icon:5});
		}else{
			//验证唯一性
			$.ajax({
				url:"<?php echo url('login/checkOnly'); ?>",
				method:'post',
				data:{user_email:user_email},
				async:false,
				success:function(msg){
					//判断返回的条数为0，证明邮箱可用
					if(msg==0){
						//进入倒计时
						$('#span_email').text(5);
						//调用倒计时函数，setInterval(函数或者代码,毫秒) 周期性的调用djs函数
						sTime=setInterval(djs,1000);
						
						//大宋ajax请求
						$.post(
							"<?php echo url('login/sendEmail'); ?>",
							{user_email:user_email},
							function(msg){
								layer.msg(msg.content,{icon:msg.icon,time:2000});
							},
							'json'
						);
					}else{
						layer.msg('邮箱已被注册',{icon:msg.icon,time:2000});
					}
				},
				dataType:'json'
			});
		}	
	});	

	//表单监听事件
	form.on('submit(eamailDemo)',function(data){
		//提交ajax请求
		$.post(
			"<?php echo url('login/register'); ?>",
			data.field,
			function(msg){
				layer.msg(msg.content,{icon:msg.icon,time:1000},function(){
					if(msg.code==1){
						location.href("<?php echo url('login/login'); ?>");
					}
				});
			},
			'json'
			);

		return false;
	});	
	});

	//声明一个变量，用于保存setInterval返回的id
	var sTime;
	//定义倒计时函数
	function djs(){
		var num=$('#span_email').text();
		if(num>1){
			num--;
			$('#span_email').text(num);
			$('#span_email').css('pointer-events','none');
		}else{
			clearInterval(sTime);
			$('#span_email').text('获取');
			$('#span_email').css('pointer-events','auto');
		}
	}
</script>


								</div>
								<!--手机号注册-->
								<div class="am-tab-panel">
									<form method="post" class="layui-form">
										<div class="user-phone">
											<label for="tel"><i class="am-icon-mobile-phone am-icon-md"></i></label>
											<input type="tel" name="user_tel" lay-verify="required|phone"  id="tel" placeholder="请输入手机号">
										</div>
										<div class="verification">
											<label for="tel_code"><i class="am-icon-code-fork"></i></label>
											<input type="tel" name="user_code" lay-verify="required" id="tel_code" placeholder="请输入验证码">
											<a class="btn" href="javascript:void(0);" id="sendTelCode">
												<span class="dyButton" id="span_tel">获取</span>
											</a>
										</div>
										<div class="user-pass">
											<label for="tel_pwd"><i class="am-icon-lock"></i></label>
											<input type="password" name="user_pwd" lay-verify="checkpwd1" id="tel_pwd" placeholder="设置密码">
										</div>
										<div class="user-pass">
											<label for="tel_pwd1"><i class="am-icon-lock"></i></label>
											<input type="password" name="user_pwd1" lay-verify="checkpwd2" id="tel_pwd1" placeholder="确认密码">
										</div>
										<div class="am-cf">
											<input type="button" lay-submit lay-filter="telDemo" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
										</div>
									</form>

								</div>
								<script>
									$(function() {
									    $('#doc-my-tabs').tabs();
									  })
								</script>
							</div>
						</div>

				</div>
			</div>
			
			<div class="footer ">
				<div class="footer-hd ">
					<p>
						<a href="# ">恒望科技</a>
						<b>|</b>
						<a href="# ">商城首页</a>
						<b>|</b>
						<a href="# ">支付宝</a>
						<b>|</b>
						<a href="# ">物流</a>
					</p>
				</div>
				<div class="footer-bd ">
					<p>
						<a href="# ">关于恒望</a>
						<a href="# ">合作伙伴</a>
						<a href="# ">联系我们</a>
						<a href="# ">网站地图</a>
						<em>© 2015-2025 Hengwang.com 版权所有. 更多模板 <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></em>
					</p>
				</div>
			</div>
	</body>

</html>
