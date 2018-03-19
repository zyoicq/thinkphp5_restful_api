<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 16:21
 */

namespace app\api\controller;


class Article extends Common{
    public function add_article(){
       //echo 'add article.';
       /** 接收参数 */
       $data = $this->params;
       $data['article_ctime'] = time();
       $res = db('article')->insertGetId($data);
       if($res){
           $this->return_msg(200,'新增文章成功!',$res);
       }else{
           $this->return_msg(400,'新增文章失败!');
       }
    }

}