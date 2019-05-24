<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;


class Goods extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
       //接收搜索条件
       $cate_id=input('get.cate_id');
       $brand_id=input('get.brand_id');
       $goods_name=input('get.goods_name'); 

       //判断条件是否存在
       $where=[];
       if(!empty($cate_id)){
            $where[]=['cate_id','=',$cate_id];
       }
       if(!empty($brand_id)){
            $where[]=['brand_id','=',$brand_id];
        }    
        if(!empty($goods_name)){
            $where[]=['goods_name','like',"%{$goods_name}%"];
        }    

       // 关联与载入with('动态属性一、动态属性二')动态属性:关联模型中的方法cate、brand
       $data=model('Goods')->with('cate','brand')->order('goods_id','desc')->where($where)->select();

       $this->assign('data',$data);
       //获取分类信息
       $cate=getCateInfo(model('Category')->where(['cate_show'=>1])->select());
       //获取分类信息
       $brand=model('Brand')->where(['brand_show'=>1])->order(['brand_sort'=>'desc','brand_id'=>'desc'])->select();
       $this->assign('cate',$cate);
       $this->assign('brand',$brand);
       return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
         //获取分类信息
        $info=model('Category')->where(['cate_show'=>1])->select();
        $cate=getCateInfo($info);
        //获取品牌信息
        $brand=model('Brand')->where(['brand_show'=>1])->order(['brand_sort'=>'desc','brand_id'=>'desc'])->select();
        //分配数据
        $this->assign('cate',$cate);
        $this->assign('brand',$brand);
        //调用视图
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if($request->isPost() && $request->isAjax()){
            //接收数据
            $data=$request->post();
            $validate=validate('Goods');
            if(!$validate->check($data)){
                echo json_encode(['conten'=>$validate->getError(),'icon'=>2,'code'=>2]);
            }
            $res=model('Goods')->save($data);
            if($res){
                echo json_encode(['content'=>'添加成功','icon'=>1,'code'=>1]);
            }else{
                echo json_encode(['content'=>'添加失败','icon'=>2,'code'=>2]);
            }
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($goods_id)
    {
        //根据参数goods_id查询当前数据
        $goods=model('Goods')->find($goods_id);
        //查询分类\品牌信息
        $cate=getCateInfo(model('Category')->where(['cate_show'=>1])->select());
        $brand=model('Brand')->where(['brand_show'=>1])->select();
        $this->assign('cate',$cate);
        $this->assign('brand',$brand);
        $this->assign('goods',$goods);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $goods_id)
    {
        if(request()->isPost() && request()->isAjax()){
            //接收数据
            $data=$request->post();
            //数据验证
            $validate=validate('Goods');
            if(!$validate->check($data)){
                echo json_encode(['content'=>$validate->getError(),'icon'=>2,'code'=>2]);exit;
            }
            //获取原数据
            $goods=\app\admin\model\Goods::get($data['goods_id']);
            //修改数据
            $res=model('Goods')->save($data,['goods_id'=>$data['goods_id']]);
            if($res){
                //判断用户是否更改，如果更好，删除原图
                if($goods->getData('goods_img') != $data['goods_img']){
                    @unlink(".$goods->goods_img");
                }else if($goods->getData('goods_simg') != $data['goods_simg']){
                    foreach ($goods->goods_simg as $value){@unlink(".$value");}
                    foreach ($goods->goods_mimg as $value){@unlink(".$value");}
                    foreach ($goods->goods_bimg as $value){@unlink(".$value");}   
                }
                echo json_encode(['cintent'=>'修改成功','icon'=>1,'code'=>1]);
            }else{
                @unlink($data['goods_img']);//删除新图
                $goods_simg=explode('|',ltrim($data['goods_simg'],'|'));
                foreach ($goods->goods_simg as $value){@unlink(".$value");}
                $goods_mimg=explode('|',ltrim($data['goods_mimg'],'|'));
                foreach ($goods->goods_mimg as $value){@unlink(".$value");}
                $goods_bimg=explode('|',ltrim($data['goods_bimg'],'|'));
                foreach ($goods->goods_bimg as $value){@unlink(".$value");}
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($goods_id)
    {
        //接收数据
       
        $goods= \app\admin\model\Goods::get($goods_id);
        $res=$goods->delete();
        if($res){
            //删除缩略图
            @unlink('.'.$goods->goods_img);
            //删除轮播图
            foreach($goods->goods_simg as $value){
                @unlink('.'.$value);
            }
            foreach($goods->goods_mimg as $value){
                @unlink('.'.$value);
            }
            foreach($goods->goods_bimg as $value){
                @unlink('.'.$value);
            }
            $this->success('删除成功','goods/index');
      }else{
            $this->error('删除失败');
      }
    }
    
    public function dels(){
        $goods_id=request()->post('goods_id');
        $flag=0;
        foreach($goods_id as $k => $v){
            if($this->del($v)) {$flag++;}
        }
        if($flag){
            echo json_encode(['content'=>"成功删除{$flag}条数据",'icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'删除失败','icon'=>2,'code'=>2]);
        }
    }

    public function del($goods_id){
        $goods=\app\admin\model\Goods::onlyTrashed(['goods_id'=>$goods_id])->find();
        // dump($goods);die;
        $res=$goods->delete(true);
        if($res){
            //删除缩略图
            @unlink('.'.$goods->goods_img);
            //删除轮播图
            foreach($goods->goods_simg as $value){
                @unlink('.'.$value);
            }
            foreach($goods->goods_mimg as $value){
                @unlink('.'.$value);
            }
            foreach($goods->goods_bimg as $value){
                @unlink('.'.$value);
            }
            return true; 
        }else{
            return false;
        }
    }

    //回收站
    public function recycle(){
        $data=\app\admin\model\Goods::onlyTrashed();
        $this->assign('data',$data);
        return $this->fetch();
    }

     /**
     * 商品即点即改事件
     *
     * 
     */
     public function editGoodsName(){
        //接收数据
        $goods_id=input('post.goods_id');
        $goods_name=input('post.goods_name');
        //唯一性验证（略）
        //入库
        $res=model('Goods')->save(['goods_name'=>$goods_name],['goods_id'=>$goods_id]);
        if($res){
            echo json_encode(['content'=>'修改成功','icon'=>1,'code'=>1]);
        }else{
            echo json_encode(['content'=>'修改失败','icon'=>2,'code'=>2]);
        }
     }

     /**
     * 图片上传
     */
    public function up(){
        //获取表单上传文件
        $file=request()->file('file');
        //验证上传文件，并移动到指定目录
        $info=$file->validate(['ext'=>'jpg,png','size'=>'204800'])->move('./uploads/goods_img');
        //验证上传结果
        if($info){
            $src=DS.'uploads'.DS.'goods_img'.DS.$info->getSaveName();
            echo json_encode(['content'=>'上传成功','icon'=>1,'code'=>1,'src'=>$src]);
        }else{
            $content=$file->getError();
            echo json_encode(['content'=>$content,'icpn'=>5,'code'=>2]);
        }
    }

    /**
     * 多图片上传
     */
    public function ups(){
        //接收上传文件
        $file=request()->file('file');
        //设置缩略图配置项
        $config=[
            'goods_sing'=>['width'=>'100','height'=>'100','name'=>uniqid().'.jpg'],
            'goods_ming'=>['width'=>'200','height'=>'200','name'=>uniqid().'.jpg'],
            'goods_bing'=>['width'=>'400','height'=>'400','name'=>uniqid().'.jpg']
        ];
        //分别生成大中小三种缩略图
        foreach ($config as $k => $v) {
            //打开资源文件
            $image=\think\Image::open($file);
            //定义保存路径
            $thumb_path='./uploads/'.$k.'/'.date('Ymd').'/'; //./uploads/goods_simg/20190325/
            if(!is_dir($thumb_path)){ //判断目录是否存在
                mkdir($thumb_path,'0777',true);//创建目录
            }
            //生成缩略图 thumb(宽、高、强制缩放)
            $image->thumb($v['width'],$v['height'],6)->save($thumb_path.$v['name']);
            //准备返回值
            $src[$k]='/uploads/'.$k.'/'.date('Ymd').'/'.$v['name'];
        }
        
        //返回数据
        echo json_encode($src);
    }

}
