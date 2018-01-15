<?php
namespace models\module;

class hotModule extends baseModule
{
    const KEYWORD_TABLE_NAME = 'keyword';

    //展示的内容模块
    public $contentModule = [
        16 => '产品',
        9 => '维修',
        6 => '招标',
        7 => '科技',
        5 => '供求',
        13 => '品牌',
        4 => '网店',
        21 => '资讯',
        15 => '共享',
        10 => '问答'
    ];

    function __construct()
    {
        $this->moduleid = 0;
        $this->modulename = '热词';
        $this->linkurl = DT_PATH . 'hot';
    }

    /**
     * 列表重写规则
     * @param $selector
     * @return string
     */
    public function searchRewrite($selector)
    {
        $mid = isset($selector['mid']) ? $selector['mid'] : '16';
        $page = isset($selector['page']) ? '-' . $selector['page'] : '';
        return 'category-' . $mid . $page;
    }

    /**
     * 数据分类列表
     * @return array
     */
    public function getCategory(){
        $category = [];
        foreach($this->contentModule as $key =>  $value){
            $cate = [];
            $cate['word'] = $value;
            $cate['linkurl'] = $this->linkurl .'/'. $this->searchRewrite(['mid' => $key]);
            $cate['mid'] = $key;
            $category[] = $cate;
        }
        return $category;
    }
}

?>