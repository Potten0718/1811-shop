<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// require 'vendor/autoload.php';


class Email extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $mail = new PHPMailer(true);

try {
    // 服务器设置
    $mail->SMTPDebug = 2;                                       // 启用详细调试输出
    $mail->isSMTP();                                            // 设置邮件程序使用SMTP
    $mail->Host       = 'smtp.qq.com';                      // 指定主邮件和备份SMTP服务器
    $mail->SMTPAuth   = true;                                   // 启用S​​MTP身份验证
    $mail->Username   = '1444060202@qq.com';                     // SMTP 用户名
    $mail->Password   = 'fbnzmnphdjvdfeej';                               // SMTP 密码
    $mail->SMTPSecure = 'SSL';                                  // 启用TLS加密，`ssl`也接受
    $mail->Port       = 587;                                    // 要连接的TCP端口

    // 收件人设置
    $mail->setFrom('1444060202@qq.com', 'Potten');      // 发送人
    $mail->addAddress('983806427@qq.com', 'Joe User');     // 添加收件人
    // $mail->addAddress('ellen@example.com');               // 名称是可选的

    // 附件
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // 添加附件
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // 可选名称

    // 内容
    $mail->isHTML(true);                                  // 将电子邮件格式设置为HTML
    $mail->Subject = '尊敬的用户你中奖啦！老公一枚！！！';     // 邮件的主题
    $mail->Body    = '<h1>兑换码为0718；兑换地址为：我心里！</h1>';   // 邮件的主体
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';    // 这是非HTML邮件客户端的纯文本正文

    $mail->send();  // 发送邮件
    echo 'Message has been sent';   // 输出文本
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // 捕捉异常
}
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
