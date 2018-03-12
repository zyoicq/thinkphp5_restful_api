<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/7
 * Time: 16:00
 */

namespace app\api\controller;
use phpmailer\phpmailer;


use think\log;


class Code extends Common {
    public function get_code(){
        $username = $this->params['username'];
        $exist = $this->params['is_exist'];
        //Log::write(var_dump($this->params));
        $username_type = $this->check_username($username);
        switch ($username_type){
            case 'phone':
                $this->get_code_by_username($username,'phone',$exist);
                break;
            case 'email':
                $this->get_code_by_username($username,'email',$exist);
                break;
        }
    }

    /**
     * @param $phone
     * @param $exist
     *
     */
    public function get_code_by_username($username,$type,$exist){
        if ($type == 'phone'){
            $type_name = '手机';
        }else{
            $type_name = '邮箱';
        }

        $this->check_exist($username,$type,$exist);

        if (session("?",$username,'_last_send_time')){
            if(time()->session($username,'_last_send_time')<30){
                $this->return_msg(400,$type_name,'手机验证码,每30秒只能发送一次！');
            }
        }

        $code = $this->make_code(6);

        $md5_code = md5($username,'_'+ md5($code));

        session($username,'code',$md5_code);
        session($username,'last_send_time',strtotime(time()));

        if ($type == 'phone'){
            $this->send_code_to_phone($username,$md5_code);
        }else{
            $this->send_code_to_email($username,$md5_code);
        }
    }

    public function make_code($num){
        $max = pow(10,$num)-1;
        $min = pow(10,$num-1);
        return rand($min,$max);
    }

    public function send_code_to_phone($username,$exist){
        echo 'send_code_to_phone';
    }

    public function send_code_to_email($email, $code)
    {
        $toemail = $email;
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->CharSet = 'utf8';
        $mail->Host = 'smtp.163.com';
        $mail->SMTPAuth = true;
        $mail->Username = "zy123zhangyong@163.com";
        $mail->Password = "zhangyong2015";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 994;
        $mail->setFrom('zy123zhangyong@163.com', 'interface test.');
        $mail->addAddress($toemail, 'test');
        $mail->addReplyTo('zy123zhangyong@163.com', 'Reply');
        $mail->Subject = "您有新的验证码!";

        $mail->Body = '这是一个测试邮件，您的验证码是$code.验证码的有效期为1分钟.本邮件请勿回复!';

        if (!$mail->send()) {
            $this->return_msg(400, $mail->ErrorInfo);
        } else {
            $this->return_msg(200, '验证码已经发送成功，请注意查收！');
        }
    }

}