<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 14:52
 */

namespace app\api\controller;


class User extends Common {
    public function login(){
        $data = $this->params;
        dump($data);
        //echo 'welcome to function login!';
    }
}