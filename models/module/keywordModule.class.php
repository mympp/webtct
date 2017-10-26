<?php
namespace models\module;

use models\helpers\query\KeywordQuery;

//科室模块模型类，封装业务逻辑操作,充当外观角色
class keywordModule extends baseModule
{

    function __construct()
    {
        global $MODULE;
        $this->moduleid = 16;
        $this->modulename = '热词';
        $this->linkurl = $MODULE[16]['linkurl'];
    }

    //科室模块伪静态地址重写
    public function searchRewrite($selector)
    {
        if(!empty($selector['kw'])) return 'keyword.php?'.http_build_query($selector);

        //伪静态地址处理 so-catid-typeid-areaid-validated-page.html
        $kwid = isset($selector['kwid']) ? '-' . $selector['kwid'] : '-0';
        $areaid = isset($selector['areaid']) ? '-' . $selector['areaid'] : '-0';
        $page = isset($selector['page']) ? '-' . $selector['page'] : '';
        return 'kw' . $kwid . $areaid . $page . '.html';
    }

    //获取名词解析
    public function getWordAnalysis($itemid)
    {
        $keywordQuery = new KeywordQuery();
        return $keywordQuery->getWordAnalysis($itemid);
    }

    //获取推荐词语
    public function getRecommendWord($pagesize = 10,$itemid = 0)
    {
        $keywordQuery = new KeywordQuery();
        return $keywordQuery->getRecommendWord($pagesize,$itemid);
    }
}


?>