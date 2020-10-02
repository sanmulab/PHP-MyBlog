<?php 
namespace app\index\controller;

use app\index\model\UserModel;
use libs\BaseController;
use libs\Captcha;
use libs\Upload;

class UserController extends BaseController
{
    //显示注册界面
    public function register()
    {
        include $this->indexPath();
    }
    //mvc的单一入口: 要求所以内容触发都依赖于 ?a=xxx 的格式
    // ?a=captcha&c=user，验证码显示
    public function captcha()
    {
        Captcha::show();
    }

    //?a=store&c=user, 执行注册操作
    public function store()
    {
        $username = $_POST['username'];
        $nick_name =$_POST['nick_name'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $verify = $_POST['verify'];

        /**
         * 有可能的结果:
         * 0 成功
         * 1 失败
         * 2 用户名重复
         * 3 两次密码不一致
         * 4 验证码错误
         */
        if($password != $repassword){
            $error = 3;
            include $this->indexPath();
            die;
        }
        //服务器生成的验证码应该保存在session中
        //在Captcha的drawCode()方法中，存储了正确的验证码
        $code = $_SESSION['code'];
        if (strtolower($code) != strtolower($verify)) {
            $error = 4;
            include $this->indexPath();
            die;
        }

        //用户重复判断
        $model = new UserModel;   //实例化
        $exists = $model->userExists($username);
        if($exists){
            $error = 2;
            include $this->indexPath();
            die;
        }
        //存储用户信息操作
        $res = $model->store($username,$nick_name,md5($password));
        $error = $res ? 0 : 1;
        include $this->indexPath();
    }

    //?a=login&c=user，用户登录
    public function login()
    {
        include $this->indexPath();  //返回路径
    }

    //?a=doLogin&c=user, 执行用户登录操作
    public function doLogin()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $verify = $_POST['verify'];

        /**
         * 有可能的结果:
         * 0 成功
         * 1 失败
         * 4 验证码错误
         */
        $code = $_SESSION['code'];   //保存验证码信息
        if(strtolower($code) != strtolower($verify)){
            $error = 4;
            include $this->indexPath();
            die;
        }
        $model = new UserModel;
        $res = $model->getUser($username, md5($password));
         $error = $res ? 0 : 1;

        //登录状态保持: 成功时保存 用户信息到 session 中
        if ($res) {
            $_SESSION['user'] = $res;
        }

        include $this->indexPath();
    }

    //注销退出
    //?a=logout&c=user
    public function logout()
    {
        session_unset();
        session_destroy();

        $this->location('index.php');
    }

    //?a=changeSetting&c=user，更改设置界面
   public function changeSetting()
   {
    include $this->indexPath();
   }

   //更新用户设置
   public function updateSetting()
   {
    $nick_name = $_POST['nick_name'];
    $image = Upload::save('public/images/head');
    $id = $_SESSION['user']['id'];

    $model = new UserModel;
    $res = $model->updateSetting($id, $image, $nick_name);

    //若设置成功，则更新SESSION信息
    if ($res) {
        $_SESSION['user']['nick_name'] = $nick_name;
        $_SESSION['user']['user_photo'] = $image;
    }

    include $this->indexPath();
   }

   //?a=changePassword&c=user,修改密码界面
    public function changePassword()
    {
        include $this->indexPath();
    }


   //修改密码
   public function updatePassword()
   {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password2 = $_POST['new_password2'];
     /**
         * 0 成功
         * 1 失败
         * 2 旧密码错误
         * 3 新密码不一致
         */
    if ($new_password2 != $new_password) {
        $error = 3;
        include $this->indexPath();
        die;
    }
    if(md5($old_password) != $_SESSION['user']['password']){
        $error = 2;
        include $this->indexPath();
        die;
    }
    $id = $_SESSION['user']['id'];
    $model = new UserModel;
    $res = $model->updatePassword($id, md5($new_password));
    $error = $res ? 0 : 1;
    include $this->indexPath();
   }


}


?>