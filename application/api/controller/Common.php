<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 16:21
 */

namespace app\api\controller;

use think\Request;
use think\Db;
use think\Controller;
use think\Validate;
use think\log;


class Common extends Controller{
    protected $request;
    protected $validater;
    protected $params;

    protected $rules = array(
        'User'=>array(
            'login'=>array(
                'user_name' => 'require',
                'user_pwd'=>'require|length:32'
            ),
            'register'=>array(
                'user_name' =>['require'],
                'user_pwd'=>'require|length:32',
                'code' => 'require|number|length:6'
            ),
        ),
        'Code'=>array(
            'get_code'=>array(
                'username'=>'require',
                'is_exist'=>'require|number|length:1'
            )
        )
    );

    protected function _initialize()
    {
        parent::_initialize();
        $this->request = Request::instance();
        //$this->check_time($this->request->only(['time']));
        //$this->check_token($this->request->param());
        //$this->params = $this->check_prarams($this->request->except(['time','token']));
        $this->params = $this->request->param();
    }

    public function check_time($arr)
    {
        if (!isset($arr['time']) || intval($arr['time']) <= 1) {
            $this->return_msg(400, '时间戳错误！');
        }
        if (time()-intval($arr['time']) > 60) {
            $this->return_msg(400, '时间超时!');
        }
    }

    public function return_msg($code, $msg = '', $data = [])
    {
        $return_data['code'] = $code;
        $return_data['msg'] = $msg;
        $return_data['data'] = $data;
        echo json_encode($return_data);
        die;
    }

    public function check_token($arr){
        echo "check_token";
        if(!isset($arr['token'])||empty($arr['token'])){
            $this->return_msg(400,'token不能为空!');
        }
        $app_token = $arr['token'];
        unset($arr['token']);
        $service_token = '';
        foreach ($arr as $key => $value){
            $service_token .= md5($value);
        }
        $service_token = md5('api_'.$service_token.'_api');
        if($app_token !== $service_token){
            $this->return_msg(400,'token值不正确');
        }
    }

    public function check_prarams($arr){
        $rule = $this->rules[$this->request->controller()][$this->request->action()];
        $this->validater = new Validate($rule);

        if(!$this->validater->check($arr)){
            $this->return_msg(400,$this->validater->getError());
        }
        //$this->params = $arr;
        return $arr;
    }

    public function check_username($username){
        Log::write($username);
        $is_email = Validate::is($username,'email')?1:0;
        $is_phone = preg_match('/^1[3456789]\d{9}$/',$username)?4:2;

        $flag = $is_email + $is_phone;
        switch ($flag){
            case 2:
                ///null
                $this->return_msg(400,'邮箱和手机号不正确!');
                break;
            case 3:
                return 'email';
                //email
                break;
            case 4:
                return 'phone';
                //phone
                break;
            case 5:
                break;
        }
    }

    public function check_exist($value,$type,$exist){
        $type_num = ($type == "phone" ? 2:4);
        $flag = $type_num + $exist;
        $phone_res = db('user')->where('user_phone',$value)->find();
        $email_res = db('user')->where('user_email',$value)->find();

        switch ($flag){
            case 2:
                if ($phone_res){
                    $this->return_msg(400,'此手机号已被占用');
                }
                break;
            case 3:
                if (!$phone_res){
                    $this->return_msg(400,'此手机号不存在');
                }
                break;
            case 4:
                if ($email_res){
                    $this->return_msg(400,'此邮箱已被占用');
                }
                break;
            case 5:
                if (!$email_res){
                    $this->return_msg(400,'此邮箱不存在');
                }
                break;
        }
    }

    public function check_code($user_name,$code){
        $last_time = session($user_name,'_last_send_time');
        if(!$last_time){
            $last_time = time();
        }
        if(time()-$last_time > 60){
            $this->return_msg(400,'验证超时，请在一分钟内验证!');
        }
        dump(session($user_name.'_code'));//die;

        $md5_code = md5($user_name.'_'.md5($code));

        /*
        if(session($user_name."_code") !== $md5_code){
            $this->return_msg(400,'验证码不正确');
        }
        */
        session($user_name.'_code',null);
    }
}