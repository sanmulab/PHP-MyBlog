<?php 
namespace app\admin\model;

use libs\BaseModel;

class ArticleModel extends BaseModel
{
     public function getAll()
     {
         /**
         * 多表联查:
         * 文章表中 只有分类id
         * 但是前端需要分类名, 分类名在 分类表中有
         * 所以 需要联合 文章表 和 分类表才能查询
         * 
         * AS 给表起别名
         * a.* 代表文章表的所有字段
         * ON 后面是 联合的条件
         */
        $sql='SELECT a.*,c.category_name FROM coding_article AS a INNER JOIN coding_category AS c ON a.category_id=c.id ORDER BY created_at DESC';
        return $this->db->fetchAll($sql);
     }

     //查询总数量
    public function getTotal()
    {
        $sql = 'SELECT COUNT(*) AS num FROM coding_article';

        // $arr['num'];
        return $this->db->fetch($sql)['num'];
    }
    
     //设定页面显示数据量
     public function getLimit($start, $num, $subject)
     {
        if ($subject) {
              $sql="SELECT a.*,c.category_name FROM coding_article AS a INNER JOIN coding_category AS c ON a.category_id=c.id WHERE subejct LIKE %$subject% LIMIT $start,$num";
         //LIMIT 不要用占位符
        }else{
            // $sql="SELECT a.*,c.category_name FROM coding_article AS a INNER JOIN coding_category AS c ON a.category_id=c.id ORDER BY created_at DESC LIMIT $start,$num";
             $sql="SELECT a.*,c.category_name,ad.nick_name FROM coding_article as a,coding_category as c,coding_admin as ad WHERE a.category_id=c.id And ad.id=a.admin_id ORDER BY created_at DESC LIMIT $start,$num";
             
         //LIMIT 不要用占位符

        }
        
        return $this->db->fetchAll($sql);
     }

     //显示文章由哪个管理员发布的
     // public function getAdmin($aid)
     // {
     //    $sql = "SELECT ad.nick_name FROM coding_admin as ad INNER JOIN coding_article AS a ON ad.id=a.admin_id 
     //    WHERE ad.id=:aid";
     //    $args = [':aid' => $aid];
     //    return $this->db->fetchAll($sql, $args);
     // }


     //单条数据集记录查询
     public function get($id)
     {
        $sql='SELECT * FROM coding_article WHERE id=:id';
        $args=[':id'=>$id];
        return $this->db->fetch($sql,$args);
     }

     //文章存储
     public function store($aid,$subject,$content,$image,$category_id)
     {
        $sql='INSERT INTO coding_article(subject,content,subject_picture,category_id,admin_id,created_at,updated_at) VALUES(:subject,:content,:subject_picture,:category_id,:admin_id,:created_at,:updated_at)';
        $args = [
            ':subject' => $subject,
            ':content' => $content,
            ':subject_picture' => $image,
            ':category_id' => $category_id,
            ':admin_id' => $aid,
            ':created_at' => time(),
            ':updated_at' => time(),
        ];
        return $this->db->exec($sql, $args);
     }

     //文章删除
     public function destroy($id)
     {
        $sql='DELETE FROM coding_article
        WHERE id=:id';
        $args=[':id'=>$id];
        return $this->db->exec($sql,$args);
     }

     //文章上线
     public function online($id)
     {
        $sql='UPDATE coding_article SET is_online=1 WHERE id=:id';
        $args=[':id'=>$id];
        return $this->db->exec($sql,$args);
     }
     //文章下线
     public function offline($id)
    {
        $sql = 'UPDATE coding_article SET is_online=0 
        WHERE id=:id';

        $args = [
            ':id' => $id
        ];

        return $this->db->exec($sql, $args);
    }

    //文章更新
    public function update($id,$image,$subject,$content,$category_id)
    {
        $sql='UPDATE  coding_article SET subject=:subject,content=:content,subject_picture=:subject_picture,category_id=:category_id,updated_at=:updated_at WHERE id=:id';
        $args = [
            ':subject' => $subject,
            ':content' => $content,
            ':subject_picture' => $image,
            ':category_id' => $category_id,
            ':updated_at' => time(),
            ':id' => $id,
        ]; 
        return $this->db->exec($sql, $args);
    }


}


 ?>
