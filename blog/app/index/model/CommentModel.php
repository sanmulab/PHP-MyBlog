<?php 
namespace app\index\model;

use libs\BaseModel;

class CommentModel extends BaseModel
{
    //将评论保存到数据库
    public function store($uid, $aid, $comment)
    {
        $sql = 'INSERT INTO coding_comment(comment,user_id,article_id,created_at,updated_at) VALUES(:comment,:user_id,:article_id,:created_at,:updated_at)';

        $args = [
            ':comment' =>$comment,
            ':user_id' =>$uid,
            ':article_id' =>$aid,
            ':created_at' =>time(),
            ':updated_at' =>time(),
        ];
        return $this->db->exec($sql, $args);
    }

    //获取文章评论，显示到页面当中
    public function getComments($aid)
    {
        $sql = 'SELECT c.*, u.nick_name, u.user_photo 
        FROM coding_comment AS c
        INNER JOIN coding_user AS u
        ON c.user_id = u.id
        WHERE c.article_id=:aid
        ORDER BY c.created_at DESC';

        $args = [':aid' => $aid];

        return $this->db->fetchAll($sql, $args);
    }
    

}

 ?>
