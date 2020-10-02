<?php

namespace app\index\model;

use libs\BaseModel;

class CategoryModel extends BaseModel
{
    public function getAll()
    {
        $sql = 'SELECT * FROM coding_category ORDER BY sort_number DESC LIMIT 6';

        return $this->db->fetchAll($sql);
    }
}

