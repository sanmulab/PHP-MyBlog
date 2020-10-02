<?php

namespace libs;

use libs\Db;

abstract class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Db;
    }
}
