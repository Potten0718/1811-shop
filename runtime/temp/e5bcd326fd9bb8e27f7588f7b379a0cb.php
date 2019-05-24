<?php /*a:2:{s:71:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\goods\create.html";i:1554349852;s:65:"D:\lening\PHPTutorial\WWW\shop\application\admin\view\layout.html";i:1557060449;}*/ ?>
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
      <fo<form class="layui-form layui-form-pane" onsubmit="return false"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
      <input type="text" name="goods_name" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
    </div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
      <input type="text" name="goods_price" id="price" placeholder="请输入商品价格" autocomplete="off" class="layui-input">
    </div>
  </div>


   <div class="layui-form-item">
    <label class="layui-form-label">市场价格</label>
    <div class="layui-input-block"><!-- mprice-自变量 -->
      <input type="text" name="goods_mprice" id="mprice" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
    </div>
  </div>


   <div class="layui-form-item">
    <label class="layui-form-label">库存</label>
    <div class="layui-input-block">
      <input type="text" name="goods_num" placeholder="请输入商品库存数量" autocomplete="off" class="layui-input">
    </div>
  </div>


   <div class="layui-form-item">
    <label class="layui-form-label">积分</label>
    <div class="layui-input-block">
      <input type="text" name="goods_score" id="score" placeholder="请输入商品积分" autocomplete="off" class="layui-input">
    </div>
  </div>


<div class="layui-form-item">
    <label class="layui-form-label">上架</label>
    <div class="layui-input-block">
      <input type="radio" name="goods_up" value="是" title="是" checked>
      <input type="radio" name="goods_up" value="否" title="否">
    </div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">商品属性</label>
    <div class="layui-input-block">
      <input type="checkbox" name="goods_new"  title="新品" checked>
      <input type="checkbox" name="goods_best"  title="精品">
      <input type="checkbox" name="goods_hot"  title="热卖">
    </div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">上传图片</label>
    <div class="layui-input-inline">
      <input id="img"  type="text" name="goods_img" class="layui-input">
    </div>
    <div class="layui-input-inline">
    <button type="button" class="layui-btn" id="up">
    <i class="layui-icon">&#xe67c;</i>上传图片
    </button>
    </div>
  </div>
 
    <div class="layui-form-item">
    <label class="layui-form-label">上传轮播图</label>
    <div class="layui-input-inline">  
      <input id="s" type="text" name="goods_simg" value="">
      <input id="m" type="text" name="goods_mimg" >
      <input id="b" type="text" name="goods_bimg" >
    </div>
  </div>
  <div>
 <div class="layui-input-block"> 
      <button id="ups" type="button" class="layui-btn">
      <i class="layui-icon">&#xe67c;</i>上传轮播图
    </button>
  </div>
 </div>
 <div class="layui-form-item">
   <div id="goods_imgs" class="layui-input-block"></div>
 </div>




  <div class="layui-form-item">
    <label class="layui-form-label">分类</label>
    <div class="layui-input-block">
      <select name="cate_id" lay-filter="cate">
        <option value="0">请选择分类</option>
        <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo htmlentities($c['cate_id']); ?>"><?php echo str_repeat('&ensp;',$c['level']*4); ?><?php echo htmlentities($c['cate_name']); ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
    </div>
  </div>




  <div class="layui-form-item">
    <label class="layui-form-label">品牌</label>
    <div class="layui-input-block">
      <select name="brand_id" lay-filter="brand">
        <option value="0">请选择品牌</option>
        <?php if(is_array($brand) || $brand instanceof \think\Collection || $brand instanceof \think\Paginator): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$b): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo htmlentities($b['brand_id']); ?>"><?php echo htmlentities($b['brand_name']); ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
    </div>
  </div>








  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">请填写商品描述</label>
    <div class="layui-input-block">
     <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>


  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>
<!-- <script src="layui.js"></script> -->
<script>
//加载layui内置模块
layui.use(['form','layer','jquery','upload'], function(){
  var form = layui.form, layer = layui.layer, $ = layui.jquery, upload = layui.upload;
  
  //监听表单提交事件
  form.on('submit(*)', function(data){
      $.ajax({
        url:"<?php echo url('goods/save'); ?>",
        method:'post',
        data:data.field,
        success:function(data){
          layer.msg(data.content,{icon:data.icon,time:1000},function(){
            if(data.code==1){
              location.href="<?php echo url('goods/index'); ?>";
            };
          });
        },
        dataType:'json'
      });
    return false;
  });

  //自动计算市场价格
  $('#price').keyup(function(e){
    var price=$(this).val();
    var mprice=price*11/10;
    $('#mprice').val(mprice);
  });
  //自动计算商品积分
   $('#price').keyup(function(e){
    var price=$(this).val();
    var score=Math.round(price/100);
    $('#score').val(score);
  });

  //渲染上传控件
  upload.render({
    elem:'#up',//上传按钮的选择器
    url:"<?php echo url('goods/up'); ?>",//异步上传接口
    exts:'jpg|peg',//上传文件的类型
    size:2048,//允许上传的文件大小
    chooes:function(obj){
      obj.preview(function(index,file,result){
        $('#goods_img').prop('src',result).width('150');
      });
    },
    done:function(res,index,upload){
      layer.msg(res.content,{icon:res.icon,time:1000},function(){
        if(res.code==1){
          $('#img').val(res.src); //服务器端返回的已上传的图片路径
        };
      });
    }
  });

  //渲染多图片上传
  upload.render({
    elem:'#ups',//上传按钮的选择器
    url:"<?php echo url('goods/ups'); ?>",//异步上传接口
    exts:'jpg|peg',//上传文件的类型
    size:2048,//允许上传的文件大小
    multiple:true,//开启多图片上传
    number: 4,//上传图片个数
    choose:function(obj){
      obj.preview(function(index,file,result){
        $('#goods_imgs').append("<img src='"+result+"' width='150' />");
      });
    },
    allDone:function(obj){
      var str ='共上传'+obj.total+'图片,成功'+obj.successful+'张图片,失败'+obj.aborted+'张图片';
      layer.msg(str,{icon:4,time:1000});
    },
    done:function(res,index,upload){

      // var s=$('#s').val()+'|'+res.goods_simg;
    
      $('#s').val($('#s').val()+'|'+res.goods_sing);
      $('#m').val($('#m').val()+'|'+res.goods_ming);
      $('#b').val($('#b').val()+'|'+res.goods_bing);
    }
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