<?php

namespace app\index\model;

use libs\BaseModel;

class ArticleModel extends BaseModel
{
    //浏览数量+1
    public function addBrowser($id)
    {
        $sql = 'UPDATE coding_article 
        SET browse_times=browse_times+1
        WHERE id=:id';

        $args = [':id' => $id];

        return $this->db->exec($sql, $args);
    }

    //评论数量+1
    public function addComment($id)
    {
        $sql = 'UPDATE coding_article 
        SET comment_number=comment_number+1
        WHERE id=:id';

        $args = [':id' => $id];

        return $this->db->exec($sql, $args);
    }

    public function get($id)
    {
        /**
         * 页面需要管理员的 昵称 和 头像, 存放在coding_admin 表中
         * 文章表中 只有 管理员id
         * 所以必须多表联查
         */
        $sql = 'SELECT a.*, ad.nick_name, ad.admin_photo 
        FROM coding_article AS a
        INNER JOIN coding_admin AS ad
        ON a.admin_id = ad.id
        WHERE a.id=:id';

        $args  = [':id' => $id];

        return $this->db->fetch($sql, $args);
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM coding_article
        WHERE is_online=1 
        ORDER BY created_at DESC';

        return $this->db->fetchAll($sql);
    }


    //分页: 传递 起始序号 和 数量
    public function getAllLimit($start, $num, $cid)
    {
        //判断cid 来 是搜索所有内容 还是 每个分类下的
        if ($cid) {
            $sql = "SELECT * FROM coding_article
            WHERE is_online=1 AND category_id=:cid
            ORDER BY created_at DESC
            LIMIT {$start}, {$num}";

            $args = [':cid' => $cid];

            return $this->db->fetchAll($sql, $args);
        } else {
            $sql = "SELECT * FROM coding_article
            WHERE is_online=1 
            ORDER BY created_at DESC
            LIMIT {$start}, {$num}";

            return $this->db->fetchAll($sql);
        }
    }

    public function getTotal($cid)
    {
        if ($cid) {
            // 其他分类为真, 搜索某分类下的文章总数量
            $sql = 'SELECT COUNT(*) as num 
            FROM coding_article 
            WHERE is_online=1 AND category_id=:cid';

            $args = [':cid' => $cid];

            return $this->db->fetch($sql, $args)['num'];
        } else {
            //0 为假, 代表首页, 获取总数量
            $sql = 'SELECT COUNT(*) as num FROM coding_article WHERE is_online=1';
            return $this->db->fetch($sql)['num'];
        }
    }
}
