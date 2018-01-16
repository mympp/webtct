<?php
use models\helpers\data\tcdb;
use models\extensions\opensearch\CloudSearch;
use models\helpers\widget\redirect\pc_to_wap;
use models\module\baseModule;
use models\helpers\view\FriendLink;

require_once '../common.inc.php';
require_once 'common.inc.php';
require_once DT_ROOT . '/models/autoload.php';

$hotModule = baseModule::moduleInstance('hot');

$keyword_db = new tcdb('keyword');
$keyword = $hotModule->getOne(['itemid' => $itemid]);   //关键词内容

if(!$keyword){
    include load('404.inc');
}

$wapurl = pc_to_wap::forword('hot/show-' . $itemid . '.html');        //跳转到对应移动端

//分类
$category = $hotModule->getCache('getCategory',[],(3600*24));

$relevant = new relevant();
$relevant->setKeyword($keyword['word']);

//相关产品
$mall_relevant = $relevant->getRelevant(16, 16);

//相关维修
$fuwu_relevant = $relevant->getRelevant(9, 8);

//相关招标
$relevant->setSort('addtime');
$zhaobiao_relevant = $relevant->getRelevant(6, 6);

//相关科技
$relevant->setSort();
$tech_relevant = $relevant->getRelevant(7, 8);

//相关供应
$relevant->setSort('addtime');
$relevant->openDbSearch('sell_5', 'itemid,title,linkurl,introduce,validated,hits,level,edittime');
$sell_relevant = $relevant->getRelevant(5, 6);

//相关品牌
$relevant->setSort();
$relevant->closeDbSearch();
$brand_relevant = $relevant->getRelevant(13, 16);

//相关网店
$company_relevant = $relevant->getRelevant(4, 16);

//相关资讯
$relevant->setSort('addtime');
$article_relevant = $relevant->getRelevant(21, 8);

//相关共享
$relevant->setSort();
$relevant->openDbSearch('down_15', 'itemid,title,linkurl,introduce,fileext,downtype,dprice');
$down_relevant = $relevant->getRelevant(15, 12);

//相关问答
$relevant->openDbSearch('know', 'itemid,title,linkurl,introduce,edittime,credit,answer,agree,against,hits');
$know_relevant = $relevant->getRelevant(10, 6);

//推荐关键词
$recommendWord = $hotModule->getRecommendWord(18,$itemid);
//最新关键词
$newWord = $hotModule->getCache('getNewWord',[22],(3600*24));
//猜测词
$relevantWord = $hotModule->getRelevantWord($keyword['word'],15);
//友情链接数据数据
$friendLink = $hotModule->getFriendLink($itemid);
$friendLinkData = [];
foreach($friendLink as $link){
    $item = [];
    $item['title'] = $link['link_name'];
    $item['linkurl'] = $link['link_url'];
    $friendLinkData[] = $item;
}
//友情链接显示
$friendLink = new FriendLink();
$friendLink->setTitle('',[
    'class' => 'links-hd'
]);
$friendLink->setLinkData($friendLinkData,[
    'div' => ['class' => 'links-bd'],
    'a' => ['target' => '_blank'],
]);
$friendLinkView = $friendLink->buildFriendLink([
    'div' => ['class' => 'layout links-layout']
]);

//seo设置
$ztitle = $keyword['word'] . '产品价格报价及售后维修_优质' . $keyword['word'] . '厂家/招标/供求 - 天成医疗网';
$zdescription = '天成医疗网为您提供最全面，丰富的' . $keyword['word'] . '相关商品详细参数信息，包括' . $keyword['word'] .
    '价格、' . $keyword['word'] . '维修、' . $keyword['word'] . '厂家；涵盖了' . $keyword['word'] . '招标、品牌型号、规格参数、
	所在地区、相关资讯等内容。';
$zkeywords = $keyword['word'] . ',' . $keyword['word'] . '价格,' . $keyword['word'] . '批发,' . $keyword['word'] . '厂家,'
    . $keyword['word'] . '供应,' . $keyword['word'] . '招标,天成医疗热词榜';

include template('show', 'hot');

//处理关键词推荐内容
class relevant
{

    private $keyword;
    private $searchIndex = 'tecenet';
    private $sort;

    private $db_search = false;    //默认不进行数据库搜索
    private $db_search_tablename;
    private $db_search_field;

    function __construct()
    {

    }

    private function dbSearch($itemid_arr)
    {
        if ($itemid_arr == false) return false;
        $module_db = new tcdb($this->db_search_tablename);
        $itemid_str = '';
        foreach ($itemid_arr as $v) {
            $itemid_str .= $v['itemid'] . ',';
        }
        $itemid_str = substr($itemid_str, 0, -1);
        return $module_db->field($this->db_search_field)->Where(['itemid' => $itemid_str], 'in')->all();
    }

    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    public function setSort($sort = '')
    {
        $this->sort = $sort;
    }

    public function openDbSearch($tablename, $field)
    {
        $this->db_search = true;
        $this->db_search_tablename = $tablename;
        $this->db_search_field = $field;
    }

    public function closeDbSearch()
    {
        $this->db_search = false;
    }

    public function getRelevant($moduleid, $pagesize)
    {
        $cSearch = new CloudSearch($this->searchIndex);
        //$cSearch->setIndex($this->searchIndex);
        $cSearch->setPageSize($pagesize);
        $cSearch->setFilter(['moduleid' => $moduleid]);

        if (!empty($this->sort)) $cSearch->setSort($this->sort);
        if ($this->db_search) {        //开启数据搜索
            $cSearch->setField('itemid');
            return $this->dbSearch($cSearch->search($this->keyword));
        }

        $result = $cSearch->search($this->keyword);

        if(empty($result)){
            $result = $cSearch->search(mb_substr($this->keyword,0,5));
        }
        return $result;
    }
}

?>