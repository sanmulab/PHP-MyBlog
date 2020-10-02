<?php

namespace app\index\controller;

use app\index\model\ArticleModel;
use app\index\model\CategoryModel;
use libs\BaseController;
use libs\Page;

class IndexController extends BaseController
{
    //首页
    public function index()
    {
        //获取所有分类
        $cateModel = new CategoryModel;
        $cates = $cateModel->getAll();

        //获取所有上线文章
        $num = 5; //每页数量
        $p = $_GET['p'] ?? 1; //页数
        $start = ($p - 1) * $num;

        // 点击首页时: 获取所有分类的文章, 此时超链接中没有 cid 参数
        // 点击其他分类时 会传递 cid
        $cid = $_GET['cid'] ?? 0; //默认值是0 代表首页

        $artModel = new ArticleModel;
        $arts = $artModel->getAllLimit($start, $num, $cid);

        $total = $artModel->getTotal($cid);
        //UI部分: 
        $page = new Page($total, $num, "a=index&c=index&cid={$cid}");

        include $this->indexPath();
    }
}
