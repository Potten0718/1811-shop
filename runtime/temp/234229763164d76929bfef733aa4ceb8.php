<?php /*a:1:{s:70:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\login\login.html";i:1556351754;}*/ ?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/login/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/login/css/demo.css" />
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="/static/admin/login/css/component.css" />
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/layui/layui.js"></script>
    <!--[if IE]>
    <script src="/static/admin/login/js/html5.js"></script>
    <![endif]-->
    <style>
        input::-webkit-input-placeholder{
            color:rgba(0, 0, 0, 0.726);
        }
        input::-moz-placeholder{   /* Mozilla Firefox 19+ */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-moz-placeholder{    /* Mozilla Firefox 4 to 18 */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-ms-input-placeholder{  /* Internet Explorer 10-11 */
            color:rgba(0, 0, 0, 0.726);
        }
    </style>
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3>登录</h3>
                <form  method="post"  class="layui-form">
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input id="username" name="admin_name" class="text" lay-verify="required" style="color: #000000 !important" type="text" placeholder="请输入账户">
                    </div>
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input id="pwd" name="admin_pwd" class="text" lay-verify="required" style="color: #000000 !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                    </div>
                    <div>
                        <input type="text" name="admin_code" lay-verify="required" style="width: 120px;height: 50px;border-radius: 25px;border: 1px solid #ccc;">
                        <img src="<?php echo captcha_src(); ?>" alt="captcha"  id="code"/>
                    </div>
                    <div id="login" class="mb2">
                        <a class="act-but submit" lay-submit lay-filter="*" href="javascript:;"  style="color: #FFFFFF">登录</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="/static/admin/login/js/TweenLite.min.js"></script>
<script src="/static/admin/login/js/EasePack.min.js"></script>
<script src="/static/admin/login/js/rAF.js"></script>
<script src="/static/admin/login/js/demo-1.js"></script>
<script src="/static/admin/login/js/Longin.js"></script>
<div style="text-align:center;">
</div>
<script type="text/javascript">
layui.use(['form','layer','jquery'],function(){
    var form = layui.form, layer = layui.layer, $ = layui.jquery;

    //自定义切换验证码函数
    function changeCaptcha(){
        $('#code').prop('src',"<?php echo captcha_src(); ?>?n="+Math.random());
    }

    // 点击切换验证码
    $('#code').click(function(){
        changeCaptcha();
    });

    //监听submit事件
    form.on('submit(*)',function(data){
        $.post(
                "<?php echo url('Login/login'); ?>",
                data.field,
                function(data){
                    layer.msg(data.content,{icon:data.icon,time:2000},function(){
                        if(data.code==1){
                            location.href="<?php echo url('index/index'); ?>";
                        }else{
                            changeCaptcha();
                        }
                    });
                },
                'json'
            );
    });
});
</script>
</body>
</html>
