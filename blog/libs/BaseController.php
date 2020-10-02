<?php

namespace libs;

//abstract: 抽象类
//代表此类只能用作父类
abstract class BaseController
{
    protected function indexPath()  //客户端路径通过方法
    {
        /**
         * 人为创造的巧合:
         * 1. 方法名 和 前端文件名一致
         * 2. 前端文件夹名 和 控制器名 一致
         */
        $c = $_GET['c'] ?? 'index';
        $a = $_GET['a'] ?? 'index';
       
        return "app/index/view/{$c}/{$a}.html";
         
    }
    protected function path()
    {
        /**
         * 人为创造的巧合:
         * 1. 方法名 和 前端文件名一致
         * 2. 前端文件夹名 和 控制器名 一致
         */
        $c = $_GET['c'] ?? 'user';  //所属文件夹
        $a = $_GET['a'] ?? 'login';  //文件夹内的链接
 
        return "app/admin/view/{$c}/{$a}.html";

    }

    protected function location($url)
    {
        header("location: {$url}");
    }
     //判断用户是否登录，防跳墙
    protected function check(){
        if (!isset($_SESSION['admin'])) {
        header('Location:?a=login');
        // echo "您还没有登录，<a href='?a=login'>请先登录!</a>";
        // return false;
          }
    }

}
