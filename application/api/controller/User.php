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

        //检测用户名类型
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type){
            case 'phone':
                $this->check_exist($data['user_name'],'phone',1);
                $db_res = db('user')
                    ->field('user_id,user_name,user_phone,user_email,user_rtime,user_pwd')
                    ->where('user_phone',$data['user_name'])
                    ->find();
                break;
            case 'email':
                $this->check_exist($data['user_name'],'email',1);
                $db_res = db('user')
                    ->field('user_id,user_name,user_phone,user_email,user_rtime,user_pwd')
                    ->where('user_phone',$data['user_name'])
                    ->find();
                break;
        }
        if($db_res['user_pwd'] !== $data['user_pwd']){
            $this->return_msg(400,'用户名或者密码不正确!');
        }else{
            unset($db_res['user_pwd']);// 密码永不返回
            $this->return_msg(200,'登录成功！',$db_res);
        }

        //dump($data);
        //echo 'welcome to function login!';
        //echo 'login';
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

    public function upload_head_img(){
        //echo "upload head img";
        //接受参数
        $data = $this->params;
        $head_img_path = $this->upload_file($data['user_icon'],'head_img');
        //dump($head_img_path);die;
        // 存入数据库
        $res = db('user')->where('user_id',$data['user_id'])->setField('user_icon',$head_img_path);
        if ($res){

            $this->return_msg(200,'头像上传成功！',$head_img_path);
        }else{
            $this->return_msg(400,'上传头像失败!');
        }
    }

    /**
     * @return bool
     */
    public function change_pwd(){
        //接受参数
        $data = $this->params;

        //检查用户名并取出数据库中的密码
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type){
            case 'phone':
                $this->check_exist($data['user_name'],'phone',1);
                $where['user_phone'] = $data['user_name'];
                break;
                case 'email':
                $this->check_exist($data['user_name'],'email',1);
                $where['user_email'] = $data['user_name'];
                break;
        }
        //判断原始密码是否正确
        $db_ini_pwd = db('user')->where($where)->value('user_pwd');
        if($db_ini_pwd !== $data['user_ini_pwd']){
            $this->return_msg(400,'原密码错误!');
        }

        //把新的密码存入数据库
        $res = db('user')->where($where)->setField('user_pwd',$data['user_pwd']);
        if ($res !== false){
            $this->return_msg(200,'密码修改成功!');
        }else{
            $this->return_msg(400,'密码修改失改!');
        }
    }

    public function find_pwd(){
       //echo 'find pwd';
        $data = $this->params;
        //$this->check_code($data['user_name'],$data['code']);
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type){
            case 'phone':
               $this->check_exist($data['user_name'],'phone',1);
               $where['user_phone'] = $data['user_name'];
               break;
            case 'email':
                $this->check_exist($data['user_name'],'email',1);
                $where['user_email'] = $data['user_name'];
                break;
        }
        $res = db('user')->where($where)->setField('user_pwd',$data['user_pwd']);
        if($res !== false){
            $this->return_msg(200,'密码修改成功!');
        }else{
            $this->return_msg(400,'密码修改失败!');
        }
    }

    public function bind_phone(){
       //echo "bind_phone" ;
        /*
         * 1.接收参数
         * 2.检查验证码
         * 3.修改数据库
         */

        $data = $this->params;
        //$this->check_code($data['phone'],$data['code']);
        $res = db('user')->where('user_id',$data['user_id'])->setField('user_phone',$data['phone']);
        if($res !== false){
            $this->return_msg(200,'手机号绑定成功!');
        }else{
            $this->return_msg(400,'手机号绑定失败!');
        }
    }

    public function bind_email(){
        //echo "bind_email" ;
        /*
         * 1.接收参数
         * 2.检查验证码
         * 3.修改数据库
         */

        $data = $this->params;
        //$this->check_code($data['phone'],$data['code']);
        $res = db('user')->where('user_id',$data['user_id'])->setField('user_email',$data['email']);
        if($res !== false){
            $this->return_msg(200,'邮箱绑定成功!');
        }else{
            $this->return_msg(400,'邮箱绑定失败!');
        }
    }

    public function bind_username(){
       //echo 'bind_username';
        /*
         * 接收参数
         */
        $data = $this->params;

        //********* 检测验证码
        //$this->check_code($data['user_name'],$data['code']);
        $user_name_type = $this->check_username($data['user_name']);
        switch ($user_name_type){
            case 'phone':
                $type_text = '手机';
                $update_data['user_phone'] = $data['user_name'];
                break;
            case 'email':
                $type_text = '邮箱';
                $update_data['user_email'] = $data['user_name'];
                break;
        }
        $res = db('user')->where('user_id',$data['user_id'])->update($update_data);
        if ($res !== false){
            $this->return_msg(200,$type_text.'绑定成功!');
        }else{
            $this->return_msg(400,'绑定失败!');
        }

    }

    public function set_nickname(){
        //echo 'set nockname';
        /** 接收参数 */
        $data =  $this->params;

        /** 检测昵称 */
        $res = db('user')->where('user_nickname',$data['user_nickname'])->find();
        if ($res){
            $this->return_msg(400,'该昵称已被占用!');
        }

        $res = db('user')->where('user_id',$data['user_id'])->setField('user_nickname',$data['user_nickname']);
        if(!$res){
            $this->return_msg(400,'修改昵称失败!');
        }else{
            $this->return_msg(200,'昵称修改成功!');
        }

    }
}