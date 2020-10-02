<?php

namespace app\index\model;

use libs\BaseModel;

class AdminModel extends BaseModel
{
    //查前5个管理员, 按照发表文章数量排序
    public function getTop5()   //显示在博主推荐页面中
    {
        /**
         * 联合 管理员表 才能查出昵称和头像
         */
        $sql = 'SELECT COUNT(a.admin_id) AS num, a.admin_id, ad.nick_name, ad.admin_photo
        FROM coding_article AS a
        INNER JOIN coding_admin AS ad 
        ON a.admin_id = ad.id
        GROUP BY a.admin_id
        ORDER BY COUNT(a.admin_id) DESC
        LIMIT 5';

        return $this->db->fetchAll($sql);
    }
}
