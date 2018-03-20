<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/6
 * Time: 16:21
 */

namespace app\api\controller;


use traits\think\Instance;

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

    public function article_list(){
        //echo 'article list';
        /** 接收参数 */
        $data = $this->params;
        if(!isset($data['num'])){
            $data['num'] = 10;
        }

        if(!isset($data['page'])){
            $data['page'] = 1;
        }

        /** 查询数据库 */
        $where['article_uid'] = $data['user_id'];
        $count = db('article')->where($where)->count();
        $page_num = ceil($count/$data['num']);
        $field = "article_id,article_ctime,article_title,user_nickname";
        $join = [['api_user u','u.user_id = a.article_uid']];
        $res = db('article')->alias('a')->field($field)->join($join)->where($where)->page($data['page'],$data['num'])->select();

        //判断并输出
        if($res === false){
            $this->return_msg(400,'查询失败!');
        }elseif (empty($res)){
            $this->return_msg(200,'暂无数据!');
        }else{
            $return_data['articles'] = $res;
            $return_data['page_num'] = $page_num;
            $this->return_msg(200,'查询成功!',$return_data);
        }

    }
    public function article_detail(){
        //echo 'article detail';
        /** 接收参数*/
        $data = $this->params;
        /** 查询数据库*/
       $field = 'article_id,article_title,article_ctime,article_content,user_nickname';
       $where['article_id'] = $data['article_id'];
       $join = [['api_user u','u.user_id = a.article_uid']];
       $res = db('article')->alias('a')->join($join)->field($field)->where($where)->find();

       $res['article_content']= htmlspecialchars_decode($res['article_content']);
       if(!$res){
           $this->return_msg(400,'查询失败!');
       }else{
           $this->return_msg(200,'获取成功!',$res);
       }
    }

    public function update_article(){
        //echo 'update article';
        /** 接收参数 */
        $data = $this->params;

        /** 存入数据库 */
        $res = db('article')->where('article_id',$data['article_id'])->update($data);
        if($res!== false){
            $this->return_msg(200,'修改文章成功!');
        }else{
            $this->return_msg(400,'修改文章失败!');
        }

    }

}