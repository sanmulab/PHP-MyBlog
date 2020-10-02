<?php 
namespace app\admin\controller;

use app\admin\model\ArticleModel;
use app\admin\model\CategoryModel;
use libs\BaseController;
use libs\Page;
use libs\Upload;

class ArticleController extends BaseController
{
    public function create()
    {
        $this->check();  //判断管理员登录状态（BaseController下）
        //查出所有分类，再已有文章分类的基础上进行添加文章
        $cateModel=new CategoryModel;
        $cates=$cateModel->getAll();
        include $this->path();
    }

    //?a=store&c=article
    public function store()
    {
        $subject=$_POST['subject'];
        if ($subject==null) {
            $error = 1;
            include $this->path();
            die; //有错误,下方就不需要执行了
        }
        $category_id=$_POST['category_id'];
        $content=$_POST['content'];
        //图片上传
        $image=Upload::save('upload/admin/images');

        //需要记录文章是哪位发表，即当前登录用户的id
        $aid=$_SESSION['admin']['id'];
        $model=new ArticleModel;
        $res=$model->store($aid,$subject,$content,$image,$category_id);
        $error = $res ? 0 : 1;
        include $this->path();
    }

    //文章列表，?a=listt&c=article
    public function listt()
    {
        $this->check();
        $model=new ArticleModel;
       //$arr=$model->getAll();
       //分页
       $num=3;   //每页三条数据
       $p=$_GET['p'] ?? 1; //当前第几页
       $total = $model->getTotal(); //总数量
       //查询指定页数的数据,  LIMIT 序号,数量
       //
       //文章管理员信息
       
       // $aid = $_SESSION['admin']['id']; //作者id
       // $admin_info = $model->getAdmin($aid);

       $start=($p-1) * $num;    //起始页下标
        $subject = $_GET['subject']?? '';
       $arr = $model->getLimit($start, $num, $subject);

        //分页的UI: 需要使用 Page 类
        //参数3 传入 a=xxx&c=xxx 这种格式
        $page = new Page($total, $num, 'a=listt&c=article');

        include $this->path();
    }

    //文章删除，？a=destroy&c=article&id=?
    public function destroy()
    {
        $id=$_GET['id'];
        $model=new ArticleModel;
        $res=$model->destroy($id);
        include $this->path();
    }
    //文章上线操作
    public function online()
    {
        $id = $_GET['id'];
        $model = new ArticleModel;
        $res = $model->online($id);
        include $this->path();
    }

    //?a=offline&c=article&id=1
    //下线
    public function offline()
    {
        $id = $_GET['id'];
        $model = new ArticleModel;
        $res = $model->offline($id);
        include $this->path();
    }

    //获取文章更新内容，?a=edit&c=article&id=?
    public function edit()
    {
        //查出所有分类
        $cateModel=new CategoryModel;
        $cates=$cateModel->getAll();

        //查出当前所要修改的文章
        $id=$_GET['id'];
        $model=new ArticleModel;
        $article=$model->get($id);
        include $this->path();

    }

    //进行文章更新，?a=update&c=article
    public function update()
    {
        $subject=$_POST['subject'];
        $category_id=$_POST['category_id'];
        $content=$_POST['content'];
        $image=Upload::save('upload/admin/images');
        $id=$_GET['id'];

        $model=new ArticleModel;
        $res=$model->update($id,$image,$subject,$content,$category_id);
        include $this->path();
    }
}
 ?>
