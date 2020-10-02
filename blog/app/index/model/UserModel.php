<?php 
namespace app\index\model;

use libs\BaseModel;

class UserModel extends BaseModel
{
    //查找用户名
    public function userExists($username)
    {
        $sql = 'SELECT * FROM coding_user WHERE username=:username';
        $args = [':username' => $username];
        return $this->db->fetch($sql , $args);
    }

    //执行用户注册
    public function store($username,$nick_name,$password)
    {
        $sql = 'INSERT INTO coding_user(username,nick_name,password,user_photo,created_at,updated_at) VALUES(:username,:nick_name,:password,:user_photo,:created_at,:updated_at)';

        $args = [
            'username' => $username,
            'nick_name' => $nick_name,
            'password'  => $password,
            'user_photo' => '',   //暂时默认无头像
            'created_at' => time(),
            'updated_at' => time(),
        ];
        return $this->db->exec($sql,$args);
    }

    //执行用户登录操作
    public function getUser($username, $password)
    {
        $sql = 'SELECT * FROM coding_user WHERE username=:username AND password=:password';
        $args = [
        ':username' => $username,
        ':password' => $password,
        ];
        return $this->db->fetch($sql, $args);
    }

    //执行用户设置操作
    public function updateSetting($id, $image, $nick_name)
    {
        $sql = 'UPDATE coding_user SET nick_name=:nick_name,user_photo=:user_photo,updated_at=:updated_at WHERE id=:id';

        $args = [
            ':nick_name' => $nick_name,
            ':user_photo' => $image,
            ':updated_at' => time(),
            ':id' => $id,
        ];
        return $this->db->exec($sql, $args);
    }

    //用户修改密码操作
    public function updatePassword($id, $new_password)
    {
        $sql = 'UPDATE coding_user SET password=:password WHERE id=:id';
        $args = [
            ':password' => $new_password,
            ':id' => $id,
        ];
        return $this->db->exec($sql, $args);
    }
}


 ?>
