<?php 
namespace app\index\controller;

use app\index\model\AdminModel;
use app\index\model\ArticleModel;
use libs\BaseController;
use app\index\model\CategoryModel;
use app\index\model\CommentModel;

class ArticleController extends BaseController
{
    //前台具体文章显示界面
    public function varticle()
    {
       //获取所有分类
        $cateModel = new CategoryModel;
        $cates = $cateModel->getAll();

        $cid = $_GET['cid'] ?? 0; //默认值是0 代表首页
        $id = $_GET['id'] ?? $cid;
        $model = new ArticleModel;
        $article = $model->get($id);
        //获取发表文章数量前5管理员（显示在博主推荐页面中）
        $adminModel = new AdminModel;
        $admins = $adminModel->getTop5();
        //查询出所有评论
        $commentModel = new CommentModel;
        $comments = $commentModel->getComments($id);

        //浏览数量+1
        $model->addBrowser($id);

         include $this->indexPath();

    }

   
}
 ?>
