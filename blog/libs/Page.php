<?php

//Page.php
//分页: 
namespace libs;

/**
 * 参数1: 总数量
 * 参数2: 每页数量
 */
// $page = new Page($total, $num);

class Page
{
    public $total;
    public $num;

    public $pageNum; //总页数
    public $p; //当前页数
    public $args;

    /**
     * @param int $total 总数量
     * @param int $num 每页数量
     * 
     * 由于之前封装Page的时候没讲单一入口, 所以缺少一个参数
     * 添加参数3 来传递 a=xxx&c=xxx 这个字符串
     */
    public function __construct($total, $num, $args = '')
    {
        $this->total = $total;
        $this->num = $num;
        $this->args = $args;

        $this->pageNum = ceil($total / $num);
        $this->p = $_GET['p'] ?? 1;
    }

    //提供几个方法, 根据已有的成员属性来 得到 对应的超链接路径

    //上一页
    public function prevURL()
    {
        // ?p=xx&a=xxx&c=xxx
        return "?p=" . ($this->p - 1) . '&' . $this->args;
    }

    //下一页
    public function nextURL()
    {
        return "?p=" . ($this->p + 1) . '&' . $this->args;
    }

    //中间页
    public function midURLs()
    {
        $min = max($this->p - 3, 1); //取得较大值, 保障最小为1
        $max = min($min + 4, $this->pageNum); //较小值, 最大为总页数
        $min = max($max - 4, 1);

        //设计返回值:  需要返回 每个页选项的 页数 和 超链接路径

        // $urls = [
        //     0 => ['page' => 1, 'url' => '?p=1'],
        //     1 => ['page' => 2, 'url' => '?p=2'],
        // ];

        $urls = [];
        for ($i = $min; $i <= $max; $i++) {

            $tmp = [
                'page' => $i,
                'url' => "?p=$i" . '&' . $this->args
            ];

            $urls[] = $tmp;
            // $tmp['page'] = $i;
            // $tmp['url'] = "?p=$i";
        }
        return $urls;
    }
}
