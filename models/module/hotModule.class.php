<?php
namespace models\module;

use models\helpers\query\KeywordQuery;
use models\helpers\widget\nlp\scws;
use models\helpers\query\KeywordLinkQuery;


class hotModule extends baseModule
{
    const KEYWORD_TABLE_NAME = 'keyword';
    const CHECKED_STATUS = 3;           //已通过状态

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
     * 构建数据列表
     * @param array $result
     * @return array
     */
    private function buildResult(array $result)
    {
        $reback = [];
        $scws = new scws();
        $stopWord = $scws->getStopWord();
        foreach ($result as $key => $value) {
            if (!empty($value['itemid'])) {
                $value['linkurl'] = $this->linkurl . '/' . $this->buildShowLinkurl($value['itemid']);
            }
            //过滤敏感词
            if (!empty($value['keyword'])) {
                $value['keyword'] = str_replace($stopWord, '*', $value['keyword']);
            }
            $reback[] = $value;
        }
        return $reback;
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
     * 构建内容页面地址
     * @param $itemid
     * @return string
     */
    public function buildShowLinkurl($itemid)
    {
        return 'show-' . $itemid . '.html';
    }

    /**
     * 数据分类列表
     * @return array
     */
    public function getCategory()
    {
        $category = [];
        foreach ($this->contentModule as $key => $value) {
            $cate = [];
            $cate['word'] = $value;
            $cate['linkurl'] = $this->linkurl . '/' . $this->searchRewrite(['mid' => $key]);
            $cate['mid'] = $key;
            $category[] = $cate;
        }
        return $category;
    }

    /**
     * 获取关键词列表
     * @param $mid
     * @param $page
     * @param $pagesize
     * @return mixed
     */
    public function getList($mid, $page, $pagesize)
    {
        $condition = ['status' => self::CHECKED_STATUS, 'moduleid' => $mid];
        $keywordQuery = new KeywordQuery();
        $searchResult = $keywordQuery->getList($condition, $page, $pagesize, 'itemid,keyword');
        $result['lists'] = $this->buildResult($searchResult['lists']);
        $result['count'] = $searchResult['count'];
        return $result;
    }

    /**
     * 获取关键词内容
     * @param array $condition
     * @return mixed
     */
    public function getOne(array $condition)
    {
        $keyword = (new KeywordQuery())->getDb(KeywordQuery::TABLE_NAME)->where($condition)->one();
        $result = $this->buildResult([$keyword]);
        return $result[0];
    }

    /**
     * 获取最新关键词
     * @param $pagesize
     * @return array
     */
    public function getNewWord($pagesize)
    {
        return $this->buildResult((new KeywordQuery())->getNewWord($pagesize));
    }

    /**
     * 获取推荐关键词
     * @param $pagesize
     * @param $itemid
     * @return array
     */
    public function getRecommendWord($pagesize, $itemid)
    {
        $list = (new KeywordQuery())->getRecommendWord($pagesize, $itemid, false);
        if ($list) {
            return $this->buildResult($list);
        } else {
            return [];
        }
    }

    /**
     * 利用分词获取关联的词
     * @param $keyword
     * @param $num
     */
    public function getRelevantWord($keyword, $num)
    {
        $scws = new scws();
        if (!$scws->checkScwsExist()) {
            return [];
        }

        $scws->setWord($keyword);
        $wordArr = $scws->getSegByAttr('n');    //只提取名词分词
        //超过三个分词时，只提取后三个分词
        $wordCondition = [];
        if (count($wordArr) > 3) {
            $reverseArr = array_reverse($wordArr);
            $i = 0;
            foreach ($reverseArr as $word) {
                $wordCondition = $word;
                if ($i++ > 2) break;
            }
        } else {
            $wordCondition = $wordArr;
        }
        //模糊匹配关键词
        $db = (new KeywordQuery())->getDb(KeywordQuery::TABLE_NAME);
        foreach ($wordCondition as $word) {
            $db->likeWhere(['keyword' => $word], false);
        }
        $lists = $db->where(['status' => KeywordQuery::CHECKED_STTAUS])
            ->order('itemid desc')->limit(0, $num)->select();
        if(!$lists){
            return [];
        }
        return $this->buildResult($lists);
    }

    /**
     * 获取关键词的友情链接内容
     * @param $itemid
     * @return mixed
     */
    public function getFriendLink($itemid){
        $db = (new KeywordLinkQuery())->getDb(KeywordLinkQuery::TABLE_NAME);
        return $db->where(['keyword_id' => $itemid])->all();
    }
}

?>