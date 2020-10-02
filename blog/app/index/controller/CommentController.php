<?php

namespace app\index\controller;

use app\index\model\ArticleModel;
use app\index\model\CommentModel;
use libs\BaseController;

class CommentController extends BaseController
{
    //?a=create&c=comment&aid=?
    public function create()
    {
        $aid = $_GET['aid']; //当前文章id

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        $comment = $_POST['comment'];

        $uid = $_SESSION['user']['id']; //评论人id

        $model = new CommentModel;
        $res = $model->store($uid, $aid, $comment);

        //评论时 文章的 评论数量+1
        $artModel = new ArticleModel;
        $artModel->addComment($aid);

        //跳转回到 之前的文章详情页
        //?a=varticle&c=article&id=19
        $this->location("?a=varticle&c=article&id={$aid}");
       //return json_encode($res);
    }
}
