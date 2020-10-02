<?php

namespace app\admin\model;

use libs\BaseModel;
use libs\Db;

class CategoryModel extends BaseModel
{
    // protected $db;

    // public function __construct()
    // {
    //     $this->db = new Db;
    // }

    public function getAll()
    {
        $sql="SELECT id,category_name,sort_number,num FROM coding_category as c LEFT JOIN(SELECT category_id,COUNT(category_id) as num FROM coding_article GROUP BY category_id)  as sel ON c.id=sel.category_id ORDER BY sort_number";

        return $this->db->fetchAll($sql);
    }

    public function store($categoryName, $sortNumber)
    {
        $sql = 'INSERT INTO coding_category(category_name,sort_number,created_at,updated_at) VALUES(:category_name,:sort_number,:created_at,:updated_at)';

        $args = [
            ':category_name' => $categoryName,
            ':sort_number' => $sortNumber,
            ':created_at' => time(),
            ':updated_at' => time(),
        ];

        return $this->db->exec($sql, $args);
    }
    public function destroy($id)
    {
        $sql='DELETE FROM coding_category WHERE id=:id';
        $args = [':id' => $id];
        return $this->db->exec($sql,$args);
    }

    public function get($id)    //查出所要修改的文章分类
    {
        $sql='SELECT * FROM coding_category WHERE id=:id';
        $args=[':id'=>$id];
        return $this->db->fetch($sql,$args);
    }
    //修改文章分类
    public function update($id,$category_name,$sort_number)
    {
        $sql='UPDATE coding_category SET category_name=:category_name,sort_number=:sort_number,updated_at=:updated_at WHERE id=:id';
        $args=[
            ':category_name'=>$category_name,
            ':sort_number'=>$sort_number,
            ':updated_at'=>time(),
            ':id'=>$id,
        ];
        return $this->db->exec($sql,$args);
    }

}
