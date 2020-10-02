<?php

namespace app\admin\model;

use libs\BaseModel;

class RoleModel extends BaseModel
{
    public function getAll()
    {
        /**
         * 前端需要 每个角色 的管理员数量
         * 
         * 每种角色管理员数量?  管理员表
         * SELECT COUNT(role_id), role_id FROM coding_admin GROUP BY role_id; 
         * 
         * 用上方查询出的 数量, 角色id 组成的表, 和下方的角色表联合查询
         * 
         * 联合查询有三种方式:
         * INNER JOIN: 获取两张表的公共部分
         * LEFT/RIGHT JOIN: 获取一张表的全部, 和两张表交集的部分
         * 
         * 此处就算 数量表中没有的角色, 也应该查出来, 所以下方应该 查出左侧表中的所有内容
         */
        $sql = 'SELECT r.*, rn.num 
        FROM coding_admin_role AS r LEFT JOIN (SELECT COUNT(role_id) AS num, role_id FROM coding_admin GROUP BY role_id ) AS rn 
        ON r.id = rn.role_id ORDER BY id
        ';

        return $this->db->fetchAll($sql);
    }
}
