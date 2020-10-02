<?php

/**
 * 遵循psr-4命名规范
 * 
 * 空间名: 与 目录路径一致, 相对于入口文件的路径
 * 
 * 类名: 类名 与 文件名一致
 */

namespace app\admin\controller;

use app\admin\model\UserModel;
use app\admin\model\RoleModel;
use libs\Upload;
use libs\BaseController;

class UserController extends BaseController
{
    //方法名 与 前端文件名 一致

    public function login()
    {
        // 相对路径: 相对于实际执行此方法的文件, 在index.php 执行
        // include 'app/admin/view/user/login.html';
        include $this->path();
    }

    //?a=doLogin
    //必须要学会: 看浏览器的超链接地址, 猜到触发的方法是哪个
    public function doLogin()
    {
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';

        $username = $_POST['username'];
        $pass = $_POST['pass'];

        //到 UserModel 中写个方法, 查是否存在此用户
        $model = new UserModel;
        $user = $model->getUser($username, md5($pass));

        // var_dump($user);
        if ($user) {
            //成功: 显示 loginSuccess.html

            //把登录用户的信息保存到session中
            $_SESSION['admin'] = $user;

            // 下方调用写法可以, 但是不遵循 单一入口规范
            // 单一入口要求方法调用: ?a=方法名
            // $this->loginSuccess();

            //重定位页面的写法: location: url地址
            // header('location: ?a=loginSuccess');

            $this->location('?a=loginSuccess');
        } else {
            //失败: 显示 loginFailed.html
            // header('location: ?a=loginFailed');

            $this->location('?a=loginFailed');
        }
    }

    //?a=logout
    //退出
    public function logout()
    {
        //删除session记录
        session_unset();
        session_destroy();

        //跳转回到首页
        $this->location('?a=login');
    }

    public function loginSuccess()
    {
        // include 'app/admin/view/user/loginSuccess.html'
        include $this->path();;
    }

    public function loginFailed()
    {
        // include 'app/admin/view/user/loginFailed.html';
        include $this->path();
    }

    //添加用户,先获得相应的用户角色
    public function create()
    {
        $roleModel=new RoleModel;
        $roles=$roleModel->getAll();
        include $this->path();
    }

    //上传保存用户信息
    public function store()
    {
        $username=$_POST['username'];
        $nick_name=$_POST['nick_name'];
        $password=$_POST['password'];
        $rePassword=$_POST['rePassword'];
        $role_id=$_POST['role_id'];
        $image=Upload::save('assets\images\avatars');

        //如果前端中需要多种判定, 需要人为去设定一个 信号量, 标识
        /**
         * 设定:
         * 0  代表注册成功
         * 1  代表注册失败
         * 2  代表两次密码不一致
         * 3  代表 用户名已存在
         * 4   代表用户名密码不能为空
         */
        //1. 两次密码要一致
         if ($username==null || $password==null) {
            $error = 4;
            include $this->path();
            die; //有错误,下方就不需要执行了
        }
        if ($password != $rePassword) {
            $error = 2;
            include $this->path();
            die; //有错误,下方就不需要执行了
        }

        //2. 用户名要判断不存在
        $model = new UserModel;  //实例化
        $exists = $model->userExists($username);
        // 用户存在
        if ($exists) {
            $error = 3;
            include $this->path();
            die;
        }

        $res = $model->store($username, $nick_name, md5($password), $role_id,$image);

        $error = $res ? 0 : 1;

        // var_dump($res);
        include $this->path();
    }

    //管理员用户列表，?a=listt&c=user
    public function listt()
    {
        $model=new UserModel;
        $user=$model->getAll();
        include $this->path();
    }

    //管理员用户修改，?a=edit&c=user
    public function edit()
    {
        //获取管理员相应角色
        $roleModel=new RoleModel;
        $roles=$roleModel->getAll();

        //所要修改用户详情
        $id=$_GET['id'];
        $model=new UserModel;
        $userinfo=$model->getUserById($id);
        include $this->path();
    }

    public function update(){
        $id=$_GET['id'];
        $username=$_POST['username'];
        $nick_name=$_POST['nick_name'];
        $password=$_POST['password'];
        $rePassword=$_POST['rePassword'];
        $role_id=$_POST['role_id'];
         //如果前端中需要多种判定, 需要人为去设定一个 信号量, 标识
        /**
         * 设定:
         * 0  代表注册成功
         * 1  代表注册失败
         * 2  代表两次密码不一致
         * 3  代表 用户名已存在
         * 4   代表用户名密码不能为空
         */
        //1. 两次密码要一致
         if ($username==null || $password==null) {
            $error = 4;
            include $this->path();
            die; //有错误,下方就不需要执行了
        }
        if ($password != $rePassword) {
            $error = 2;
            include $this->path();
            die; //有错误,下方就不需要执行了
        }

        //2. 用户名要判断不存在
        $model = new UserModel;  //实例化
        $exists = $model->userExists($username);
        // 用户存在
        if ($exists) {
            $error = 3;
            include $this->path();
            die;
        }

        $res = $model->update($id,$username, $nick_name, md5($password), $role_id);

        $error = $res ? 0 : 1;

         //var_dump($res);
        include $this->path();
    }

    //管理员用户删除，?a=destory&c=user&id=?
    public function destroy()
    {
        $id = $_GET['id'];
        $model = new UserModel;  //实例化
        $res = $model->destroy($id);   //执行

        include $this->path();
    }

    // ?a=editPassword&c=user&id=
    public function editPassword()
    {
        
        include $this->path();
    }
    //当前管理员用户个人资料修改（密码）,?a=updatePassword&c=user&id=?
    public function updatePassword()
    {
        $old_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $re_new_password=$_POST['re_new_password'];
        /**
         * 4种结果:
         * 0 成功
         * 1 失败
         * 2 旧密码错
         * 3 新密码不一致
         */
        //1. 原密码要正确
        $pass=$_SESSION['admin']['password'];
        if($pass != md5($old_password)){
            $error=2;
            include $this->path();
            die;
        }

        //2. 两次新密码要一致
        if($new_password != $re_new_password){
            $error=3;
            include $this->path();
            die;
        }

        //3. 修改
        $model=new UserModel;
        $id=$_SESSION['admin']['id'];   //获取当前id
        $res=$model->updatePassword($id,md5($new_password));
        $error = $res ? 0 :1;
        include $this->path();
    }

    //修改个人资料
    public function editProfile()
    {
        include $this->path();
    }
    //上传修改信息，?a=updateProfile&c=user
    public function updateProfile()
    {
        $image=Upload::save('assets/images/avatars');
        $nick_name=$_POST['nick_name'];
        $model=new UserModel;
        $id=$_SESSION['admin']['id'];
        $res=$model->updateProfile($id,$image,$nick_name);
        //更新成功时, 应该立刻刷新 session 中存储的用户信息
        if ($res) {
            $_SESSION['admin'] = $model->getUserById($id);
        }
        include $this->path();
    }

}
