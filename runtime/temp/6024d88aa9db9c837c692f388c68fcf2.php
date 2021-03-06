<?php /*a:2:{s:73:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\category\index.html";i:1553492805;s:65:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\layout.html";i:1557060449;}*/ ?>
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
      <table class="layui-table">
  <colgroup>
    <col width="50">
    <col>
    <col>
    <col>
    <col>
    <col width="120">
  </colgroup>
  <thead>
    <tr>
      <th></th>
      <th>分类名称</th>
      <th>是否显示</th>
      <th>导航显示</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
  <tr cate_pid="<?php echo htmlentities($c['cate_pid']); ?>" cate_id="<?php echo htmlentities($c['cate_id']); ?>">
      <td><a class="sh" href="javascript:void(0)">+</a></td>
      <td><?php echo str_repeat('&ensp;',$c['level']*4); ?><?php echo htmlentities($c['cate_name']); ?></td>
      <td><?php echo htmlentities($c['cate_show']); ?></td>
      <td><?php echo htmlentities($c['cate_nav']); ?></td>
      <td><?php echo htmlentities($c['cate_time']); ?></td>
      <td>
        <div class="layui-btn-group">
      <button class="layui-btn layui-btn-sm edit">
        <i class="layui-icon">&#xe642;</i>
      </button>
      <button class="layui-btn layui-btn-sm del">
        <i class="layui-icon">&#xe640;</i>
      </button>
    </div>
      </td>
   </tr>
   <?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
</table>


<script>
  //加载layui内置模块
  layui.use(['layer','jquery'],function(){
    var layer=layui.layer,$=layui.jquery;


    //为编辑按钮绑定事件
    $('.edit').click(function(){
      location.href="<?php echo url('category/edit'); ?>?cate_id="+<?php echo htmlentities($c['cate_id']); ?>;
    });


    //为删除按钮绑定事件
    $('.del').click(function(){
      var _this=$(this);
      layer.confirm('确定删除？',{icon:3},function(index){
        var cate_id=_this.parents('tr').attr('cate_id');
        $.post(
          "<?php echo url('category/delete'); ?>",
          {cate_id:cate_id},
          function(data){
            layer.msg(data.content,{icon:data.icon,time:1000},function(){
              if(data.code==1){
                _this.parents('tr').remove();
              };
            });
          },
          'json'
          );
        layer.close(index);
      });
    });


    //当页面加载后，只显示顶级分类
    $('tr:gt(0)').each(function(){
      var cate_pid=$(this).attr('cate_pid');
      if(cate_pid!=0){
        $(this).hide();
      };
    });
    
    
    //为所有的+添加点击事件
    $('.sh').click(function(){
      //获取sh中的文本
      var shText=$(this).text();
      //判断文本是否等于+
      if(shText=='+'){
        //+变-
        $(this).text('-');
        //获取被点击行的cate_id
        var cate_id=$(this).parents('tr').attr('cate_id');
        //展示子类
        showTr(cate_id);
      }else{
        //-变+
        $(this).text('+');
        //获取被点击行的cate_id
        var cate_id=$(this).parents('tr').attr('cate_id');
        //隐藏子类
        hideTr(cate_id);
      }
    });


    //展示子类
    function showTr(cate_pid){
      $('tr').each(function(){
        if($(this).attr('cate_pid')==cate_pid){
          $(this).show();
        };
      });
    }


    //隐藏子类
    function hideTr(cate_pid){
      $('tr').each(function(){
        if($(this).attr('cate_pid')==cate_pid){
          $(this).hide();
          hideTr($(this).attr('cate_id'));
        };
      });
    }

    //是否显示，ajax修改
    $('td:nth-child(3)').click(function(){
      var _this =$(this);
      $.post(
          "<?php echo url('category/cateShow'); ?>",
          {cate_show:_this.text(),cate_id:_this.parent('tr').attr('cate_id')},
          function(data){
            layer.msg(data.content,{icon:data.icon,time:2000},function(){
                 if(data.code==1){
              _this.text()=='是' ? _this.text('否') : _this.text('是');
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