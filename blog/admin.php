<?php

// index.php

//1.自动加载
function autoload($class)
{
    $path = "$class.php";
    $path = str_replace('\\', '/', $path);
    include $path;
}
spl_autoload_register('autoload');

//单一入口: 决定了所有方法的调用都是经过此入口文件的, 所有页面都要做登录状态的判定和保持, 依赖于session, 所以在此处开启sesison
session_start();


/**
 * 问题: 项目中存在多个控制器, 所以入口文件具体实例化的是哪个控制器?
 * 参考之前 方法名 是如何变化的
 * 模仿方法名, 通过超链接传递控制器名 ?c=控制器名
 */

$c = $_GET['c'] ?? 'user';
//类名都是大驼峰, 首字母要大写
$c = ucfirst($c);

// \是转义符  \\代表普通的 \
$className = "app\\admin\\controller\\{$c}Controller";

// $obj = new app\admin\controller\UserController;
$obj = new $className;

//单一入口:  ?a=方法名
$a = $_GET['a'] ?? 'login'; //默认值是 首页的名

$obj->$a();

/**
 * 拷贝资源到 blog 目录下, 否则页面没有css样式 
 * 资源在 新版码农博客/admin 下的 三个文件夹
 */
