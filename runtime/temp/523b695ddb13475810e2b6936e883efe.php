<?php /*a:2:{s:70:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\brand\index.html";i:1553478868;s:65:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\layout.html";i:1557060449;}*/ ?>
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
          </dl>
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
      <table id="brand" lay-filter="test"></table>
<script type="text/html" id="brand_bar">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/html" id="brand_logo">
  <img src="{{d.brand_logo}}" width="25" alt="暂无图片" >
</script>
<script type="text/javascript">
 layui.use(['layer','table','jquery'],function(){
      var table=layui.table,layer=layui.layer,$=layui.jquery;
      //表名--render-固定用法
     table.render({
        elem:'#brand',
        url:"<?php echo url('Brand/indexData'); ?>", 
        even:true,//隔行换色
        cols:[[
              {field:'brand_id',title:'编号',width:60},
              {field:'brand_name',title:'品牌名称',edit:'text'},
              {field:'brand_show',title:'是否展示',width:90},
              {field:'brand_url',title:'品牌地址',width:200,edit:'text'},
              {templet:'#brand_logo',title:'品牌logo'},
              {field:'brand_time',title:'添加时间',width:180},
              {field:'brand_sort',title:'品牌排序',width:120,edit:'text'},
              {toolbar:'#brand_bar',title:'操作',width:120}
        ]]
     }); 

    table.on('tool(test)',function(obj){
      var data = obj.data, layEvent = obj.event;

      if(layEvent=='edit'){
        location.href="<?php echo url('brand/edit'); ?>?brand_id="+data.brand_id;
      }else if(layEvent=='del'){
        layer.confirm('确认要删除吗？',{icon:3,title:'询问'},function(index){
          $.post(
              "<?php echo url('brand/delete'); ?>",
              {brand_id: data.brand_id},
              function(data){
                layer.msg(data.content,{icon:data.icon,time:1000},function(){
                  if(data.code==1){
                    obj.del();
                    layer.close(index);
                  };
                });
              },
              'json'
            );
        });
      }
    });

    //监听单元格编辑
    table.on('edit(test)',function(obj){
      $.post(
          "<?php echo url('brand/editTable'); ?>",
          {fieldName: obj.field,fieldValue: obj.value,brand_id: obj.data.brand_id},
          function(data){
            layer.msg(data.content,{icon:data.icon,time:1000});
          },
          'json'
        );
    });
    
    function changeSize(index){
      var brand_log=index.src;
      layer.alert("<img src='"+brand_log+"' />",{title:'图片预览'});
    }

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