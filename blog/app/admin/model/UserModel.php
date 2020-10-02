<?php

namespace app\admin\model;

use libs\BaseModel;
use libs\Db;

class UserModel extends BaseModel
{
    // protected $db;

    // public function __construct()
    // {
    //     $this->db = new Db;
    // }

    public function getUser($username, $password)
    {
        $sql = 'SELECT * FROM coding_admin
        WHERE username=:username AND password=:password';

        $args = [
            ':username' => $username,
            ':password' => $password
        ];

        return $this->db->fetch($sql, $args);
    }
    //判断用户名存在
    public function userExists($username)
    {
        $sql = 'SELECT * FROM coding_admin WHERE username=:username';

        $args = [':username' => $username];

        return $this->db->fetch($sql, $args);
    }
    
    //用户信息存储
    public function store($username,$nick_name,$password,$role_id,$image)
    {
        $sql='INSERT INTO coding_admin(username,password,nick_name,admin_photo,role_id,created_at,updated_at) VALUES(:username,:password,:nick_name,:admin_photo,:role_id,:created_at,:updated_at)';

        $args = [
            ':username' => $username,
            ':password' => $password,
            ':nick_name' => $nick_name,
            ':admin_photo' => $image, 
            ':role_id' => $role_id,
            ':created_at' => time(),
            ':updated_at' => time(),
        ];
        return $this->db->exec($sql,$args);
    }

    //管理员用户列表展示
    public function getAll()
    {
        /**
         * 管理员表中 有角色id 没有角色名
         * 角色表中 有角色id 和 角色名
         * 所以联合查询
         */
        $sql = 'SELECT a.*, r.role_name 
        FROM coding_admin AS a
        INNER JOIN coding_admin_role AS r
        ON a.role_id = r.id';

        return $this->db->fetchAll($sql);
    }

    //获取所需修改的管理员用户信息
    public function getUserById($id)
    {
        $sql='SELECT * FROM coding_admin where id=:id';
        $args=[':id'=>$id];
        return $this->db->fetch($sql,$args);
    }

    //管理用户信息修改
    public function update($id,$username,$nick_name,$password,$role_id)
    {
        $sql='UPDATE coding_admin SET username=:username,password=:password,nick_name=:nick_name,role_id=:role_id,updated_at=:updated_at WHERE id=:id';

        $args=[
            ':username'=>$username,
            ':password'=>$password,
            'nick_name'=>$nick_name,
            'role_id'=>$role_id,
            'updated_at'=>time(),
            ':id'=>$id,
        ];
        return $this->db->exec($sql,$args);
    }
    //管理员用户删除
    public function destroy($id)
    {
        $sql='DELETE FROM coding_admin WHERE id=:id';
        $args=[':id'=>$id];
        return $this->db->exec($sql,$args);
    }

    //当前用户个人密码修改
    public function updatePassword($id,$new_password)
    {
        $sql = 'UPDATE coding_admin SET password=:password
     WHERE id=:id';
         $args = [
            ':id' => $id,
            ':password' => $new_password
        ];

        return $this->db->exec($sql, $args);
    }
    //修改个人资料
    public function updateProfile($id,$image,$nick_name)
    {
        $sql='UPDATE coding_admin SET nick_name=:nick_name,admin_photo=:admin_photo WHERE id=:id';
        $args=[
            ':nick_name'=>$nick_name,
            ':admin_photo'=>$image,
            ':id'=>$id,
        ];
        return $this->db->exec($sql,$args);
    }

}
