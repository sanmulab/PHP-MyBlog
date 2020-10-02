<?php

namespace app\admin\controller;

use app\admin\model\CategoryModel;
use libs\BaseController;

//继承 extends
class CategoryController extends BaseController
{
    //前端文件名 和 方法名 一致

    //?a=create&c=category
    public function create()
    {
        // include 'app/admin/view/category/create.html';
        include $this->path();
    }

    //?a=store&c=category
    public function store()
    {
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

        $category_name = $_POST['category_name'];
        $sort_number = $_POST['sort_number'];

        $model = new CategoryModel;
        $res = $model->store($category_name, $sort_number);    //获取结果数据集

        // var_dump($res);
        // include 'app/admin/view/category/store.html';
        include $this->path();
    }

    // ?a=listt&c=category
    public function listt()
    {
        $model = new CategoryModel;
        $arr = $model->getAll();

        /**
         * 人为创造的巧合:
         * 1. 方法名 和 前端文件名一致
         * 2. 前端文件夹名 和 控制器名 一致
         */

        // $c = $_GET['c'] ?? 'user';
        // $a = $_GET['a'] ?? 'login';

        // include "app/admin/view/{$c}/{$a}.html";

        // include 'app/admin/view/category/listt.html';
        include $this->path();
    }

    //根据超链接的参数 就可以自动拼接出 前端文件路径!!
    // protected function path()
    // {
    //     /**
    //      * 人为创造的巧合:
    //      * 1. 方法名 和 前端文件名一致
    //      * 2. 前端文件夹名 和 控制器名 一致
    //      */
    //     $c = $_GET['c'] ?? 'user';
    //     $a = $_GET['a'] ?? 'login';

    //     return "app/admin/view/{$c}/{$a}.html";
    // }
    // ?a=destory&c=category&id=?
    // 删除
    public function destroy()
    {
        $id=$_GET['id'];
        $model = new CategoryModel;
        $res=$model->destroy($id);
        include $this->path();
    }
    //编辑方法
    //?a=edit&c=category&id=?
    public function edit()
    {
        $id=$_GET['id'];
        //先查再改
        $model = new CategoryModel;
        $category=$model->get($id);
        include $this->path();
    }
    public function update()
    {
        $id=$_GET['id'];
        $category_name=$_POST['category_name'];
        $sort_number=$_POST['sort_number'];
        $model = new CategoryModel;
        $res=$model->update($id,$category_name,$sort_number);
        include $this->path();

    }
}
