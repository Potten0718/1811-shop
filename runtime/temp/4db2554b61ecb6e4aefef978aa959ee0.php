<?php /*a:2:{s:74:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\yuangong\create.html";i:1556522006;s:65:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\layout.html";i:1556521923;}*/ ?>
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
    <!--     <li class="layui-nav-item layui-nav-itemed">
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
        <li class="layui-nav-item">
          <a href="javascript:;">角色管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('role/create'); ?>">角色添加</a></dd>
            <dd><a href="<?php echo url('role/index'); ?>">角色列表</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">asdf管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('asdf/create'); ?>">角色添加</a></dd>
            <dd><a href="<?php echo url('asdf/index'); ?>">角色列表</a></dd>
          </dl> -->
          <li class="layui-nav-item">
          <a href="javascript:;">员工管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('yuangong/create'); ?>">员工添加</a></dd>
            <dd><a href="<?php echo url('yuangong/index'); ?>">员工列表</a></dd>
          </dl>
        </li>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <form class="layui-form  layui-form-pane" onsubmit="return false" method="post" action="<?php echo url('admin/save'); ?>">
  <div class="layui-form-item" >
    <label class="layui-form-label">员工账号</label>
    <div class="layui-input-inline">
      <input type="text" name="yg_zhanghao"   autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属部门</label>
    <div class="layui-input-inline">
      <input type="text" name="bm_name"   autocomplete="off" class="layui-input">
    </div>
    </div>
  <div class="layui-form-item" >
    <label class="layui-form-label">出生日期</label>
    <div class="layui-input-inline">
      <input type="text" name="yg_csrq"   autocomplete="off" class="layui-input">
    </div>
  </div>
     <div class="layui-form-item">
    <label class="layui-form-label">学历</label>
    <div class="layui-input-inline">
      <input type="text" name="yg_xl"  class="layui-input" lay-skin="switch" >
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">性别</label>
    <div class="layui-input-inline">
      <input type="radio" name="yg_sex" value="男" class="layui-input">男
      <input type="radio" name="yg_sex" value="女" class="layui-input">女
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">姓名</label>
    <div class="layui-input-inline">
      <input type="text" name="yg_name"  s  autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-inline">
      <button class="layui-btn" lay-submit lay-filter="go">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
<script type="text/javascript">
//加载layipt内置模块
layui.use(['form','jquery','layer'],function(){
  var form=layui.form;
  var $ = layui.jquery;
  var layer=layui.layer;
 
 form.on('submit(go)',function(data){
    // console.log(data);
    // 发送ajax请求，做添加
    $.post(
      "<?php echo url('yuangong/save'); ?>",
      data.field,
      function(data){
        layer.msg(data.content,{icon:data.icon,time:2000},function(){
          if(data.code==1){
            location.href="<?php echo url('yuangong/index'); ?>";
          };
        });
      },
      'json'
    );
    return false;//阻止表单提交
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