<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 14:52
 */

namespace app\api\controller;
use think\Log;

class User extends Common {
    public function login(){
        $data = $this->params;
        dump($data);
        //echo 'welcome to function login!';
    }

    public function register(){
        //echo 'register';
        $data = $this->params;
        $this->check_code($data['user_name'],$data['code']);
        Log::write('check_code');
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type){
            case 'phone';
               $this->check_exist($data['user_name'],'phone',0);
               $data['user_phone'] = $data['user_name'];
                break;
            case 'email':
                $this->check_exist($data['user_name'],'email',0);
                $data['user_email'] = $data['user_name'];
                break;
        }

        //将用户信息写入数据库
        unset($data['user_name']);
        $data['user_rtime'] = time();
        Log::write($data['user_rtime']);
        $res = db('user')->insert($data);
        if(!$res){
            $this->return_msg(400,'用户注册失败!');
        }else{
            $this->return_msg(200,'用户注册成功!',$res);
        }

    }


}