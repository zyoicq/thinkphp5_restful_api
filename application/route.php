<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// api.tp5.com ===> www.tp5.com/index.php/api
//Route::domain('api.tp5.com','www.tp5.com/api');
Route::domain('api','api');
//api.tp5.com/user/2 ==> www.tp5.com/index.php/api/user/index/id/2
Route::rule('user/:id','user/index');

//post api.tp5.com/user user.php login()
Route::post('user','user/login');

Route::get('code/:time/:token/:username/:is_exist','code/get_code');

Route::post('user/register','user/register');

Route::post('user/login','user/login');

Route::post('user/icon','user/upload_head_img');

Route::post('user/change_pwd','user/change_pwd');

Route::post('user/find_pwd','user/find_pwd');

Route::post('user/bind_phone','user/bind_phone');

Route::post('user/bind_email','user/bind_email');

Route::post('user/bind_username','user/bind_username');

Route::post('user/nickname','user/set_nickname');

/** article */
//新增文章
Route::post('article','article/add_article');

//查看文章列表
Route::get('articles/:time/:token/:user_id/[:num]/[:page]','article/article_list');

//查看文章信息
Route::get('article/:time/:token/:article_id','article/article_detail');

//修改/更新文章列表
Route::put('article','article/update_article');

//删除文章
Route::delete('article/:time/:token/:article_id','article/del_article');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
