<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends Common
{

    public function login()
        {
            if(request()->isPost() && request()->isAjax()){
                //接收数据
                $data = input('post.');
                //数据验证
                if(empty($data['account'])){
                    echo json_encode(['content'=>'邮箱或者手机号不能为空','icon'=>5,'code'=>2]);exit;
                }
                //验证密码非空
                if(empty($data['user_pwd'])){
                    echo json_encode(['content'=>'密码不能为空','icon'=>5,'code'=>2]);exit;
                }
                //验证邮箱查询用户信息
                $user = model('User')->where(['user_email'=>$data['account']])->find();
                //判断用户是否存在
                if($user){
                    //数据库存储的密码
                    $user_pwd = $user['user_pwd'];
                    //用户提交的密码  
                    $pwd = md5($data['user_pwd']);
                    //提取数据库中存储的错误时间
                    $error_time = $user['error_time'];
                    //获取数据库中存储的错误次数
                    $error_num = $user['error_num'];
                    //获取当前时间
                    $now = time();  
                    //验证密码是否正确
                    if($user_pwd != $pwd){
                        //密码错误，判断错误时间是否大于24小时
                        if($now-$error_time>86400){
                            //超过一天，将错误次数修改为1，并记录错误时间为当前时间，提示用户还可以输入4次
                            $userinfo = ['error_num'=>1,'error_time'=>$now];
                            model('User')->save($userinfo,['user_id'=>$user['user_id']]);
                            echo json_encode(['content'=>'密码错误，您还可以输入4次','icon'=>5,'code'=>2]);
                        }else{
                            //没超过一天，判断错误次数是否大于等于5次
                            if($error_num>=5){
                                //提示用户被锁定
                                echo json_encode(['content'=>'用户已被锁定','icon'=>5,'code'=>2]);
                            }else{
                                //错误次数加1，提示用户还可以输入（5-错误次数）次
                                $userinfo = ['error_num'=>['inc',1]];
                                model('User')->save($userinfo,['user_id'=>$user['user_id']]);
                                $num = 4-$error_num;
                                echo json_encode(['content'=>"密码错误，您还可以输入{$num}次",'icon'=>5,'code'=>2]);
                            }
                        }
                       
                    }else{
                        //密码正确，判断错误次数>5并且 错误时间<1天
                        if($error_num>=5 && $now-$error_time <86400){
                            //提示“账号锁定，错误时间+1天”后可以登陆
                            $day = date('Y-m-d H:i:s',$error_time+86400);
                            echo json_encode(['content'=>"账号已被锁定,{$day}后可以登录"]);
                        }else{
                            //错误次数清零，错误时间清空
                            $userinfo = ['error_num'=>0,'error_time'=>0];
                            model('User')->save($userinfo,['user_id'=>$user['user_id']]);
                            //判断是否记住密码（'remember_me'是布尔值）
                            if($data['remember_me']){
                                //将账号、密码（明文密码）序列化后写入cookie
                                $info = serialize(['account'=>$user['user_email'],'user_pwd'=>$data['user_pwd']]);
                                cookie('info',$info,604800);
                                //将用户id和用户名写入session
                                session('uinfo',['user_id'=>$user['user_id'],'user_email'=>$user['user_email']]);
                            }
                        }
                            //将登陆时间和登录ip写入数据库
                        $updateInfo = [
                            'login_time' => time(),
                            'login_ip' =>request()->ip()
                        ];
                        model('User')->save($updateInfo,['user_id'=>$user['user_id']]);

                        //同步浏览历史
                        $this->asyncHistory();
                        $this->asyncCart();
                        echo json_encode(['content'=>'登陆成功','icon'=>6,'code'=>1]);
                    }
                    }else{
                    echo json_encode(['content'=>'该用户邮箱未注册','icon'=>5,'code'=>2]);exit;
                }
            }else{
                //取出cookie中的用户信息
                $info = unserialize(cookie('info'));
                //分配到试图页面
                $this->view->engine->layout(false);
                $this->assign('info',$info);
                //调用视图
                return $this->fetch();
            }
        }
    /**
     * 注册
     *
     * @return \think\Response
     */
    public function register()
    {
        if(request()->isPost() && request()->isAjax()){
            //接收数据
            $data=input('post.');
            // dump($data);die;
            //数据验证：验证验证码，验证邮箱、密码、确认密码
            //验证验证码是否失效
            $time=cookie('time');
            if(time()-60>$time){
                echo json_encode(['content'=>'验证码失效，请重试！','icon'=>2,'code'=>2]);exit;
            }
            if($data['user_code'] != session('user_code')){
                echo json_encode(['content'=>'验证码错误，请重试！','icon'=>2,'code'=>2]);exit;
            }
            //验证邮箱、密码、确认密码（用验证器验证）
            $validate=validate('User');
            if(!$validate->check($data)){
                echo json_encode(['content'=>$validate->getError(),'icon'=>2,'code'=>2]);exit;
            }
            //入库
            $res=model('User')->save($data);
            if($res){
                echo json_encode(['content'=>'注册成功','icon'=>1,'code'=>1]);
            }else{
                echo json_encode(['content'=>'注册失败','icon'=>2,'code'=>2]);
            }
        }else{
            $this->view->engine->layout(false);
             return $this->fetch();
        }   
    }

    //邮件发送
    public function sendEmail(){
        //接收ajax
        $user_email=input('post.user_email');
        //设置验证码
        $body= mt_rand(100000,999999);
        // dump($body);die;
        //设置邮件主题
        $subject="验证码";
        
        $mail = new PHPMailer(true);
        try {
            // 服务器设置
            $mail->SMTPDebug = 0;                                       // 启用详细调试输出
            $mail->isSMTP();                                            // 设置邮件程序使用SMTP
            $mail->Host       = 'smtp.qq.com';                      // 指定主邮件和备份SMTP服务器
            $mail->SMTPAuth   = true;                                   // 启用S​​MTP身份验证
            $mail->Username   = '1444060202@qq.com';                     // SMTP 用户名
            $mail->Password   = 'fbnzmnphdjvdfeej';                               // SMTP 密码
            $mail->SMTPSecure = 'SSL';                                  // 启用TLS加密，`ssl`也接受
            $mail->Port       = 587;                                    // 要连接的TCP端口

            // 收件人设置
            $mail->setFrom('1444060202@qq.com', 'Potten');      // 发送人
            $mail->addAddress($user_email, 'Joe User');     // 添加收件人
            // $mail->addAddress('ellen@example.com');               // 名称是可选的

            // 附件
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // 添加附件
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // 可选名称

            // 内容
            $mail->isHTML(true);                                  // 将电子邮件格式设置为HTML
            $mail->Subject = $subject;     // 邮件的主题
            $mail->Body    = $body;   // 邮件的主体
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';    // 这是非HTML邮件客户端的纯文本正文

            $res=$mail->send();  // 发送邮件
            // echo 'Message has been sent';   // 输出文本
            if($res){
                session('user_code',$body);
                setcookie('time',time());
                echo json_encode(['content'=>'验证码发送成功，请注意查收','icon'=>6]);
            }else{
                 echo json_encode(['content'=>'验证码发送失败，请重试','icon'=>5]);
            }
        } catch (Exception $e) {
            echo json_encode(['content'=>$mail->ErrorInfo,'icon'=>5]); // 捕捉异常
        }
    }

    //验证邮箱唯一性
    public function checkOnly(){
       $user_email=input('post.user_email');
       return db('user')->where(['user_email'=>$user_email])->count();
    }
    /**
     * [loginOut description]
     * @return [type] [description]
     */
    public function loginOut(){
        session('uinfo',null);
        $this->success('退出成功','login/login');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
