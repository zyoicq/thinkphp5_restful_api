<?php

namespace app\index\controller;
use think\Db;

class Index {
    public function index() {
        $res = Db::query('select version()');
        return json_encode($res);
    }
}
