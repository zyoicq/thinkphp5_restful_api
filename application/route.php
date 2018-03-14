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

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
