<?php

namespace app\admin\controller;

use libs\BaseController;
use libs\Db;


class IndexController extends BaseController
{
    // ?a=index&c=index
    public function index()
    {
        $this->check();
        //到 libs/Db 类中, 新增一个 version() 方法
        //$db = new Db;
        // include 'app/admin/view/index/index.html';
        include $this->path();
    }
}
