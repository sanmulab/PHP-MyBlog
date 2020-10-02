<?php
namespace app\admin\controller;

use app\admin\model\RoleModel;
use libs\BaseController;

class RoleController extends BaseController
{
    //显示管理员角色列表，?a=listt&c=role
    public function listt()
    {
        $model=new RoleModel;
        $arr=$model->getAll();
        include $this->path();
    }
}
 ?>
