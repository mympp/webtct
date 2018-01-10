<?php
use models\helpers\data\tcdb;
use models\extensions\opensearch\CloudSearch;
use models\helpers\data\category;
use models\module\baseModule;
use models\helpers\query\MallQuery;
use models\helpers\query\CompanyQuery;
use models\helpers\view\pagination;
use models\helpers\widget\redirect\pc_to_wap;
use models\helpers\widget\nlp\scws;

defined('IN_DESTOON') or exit('Access Denied');
//$itemid or dheader($MOD['linkurl']);

if (empty($itemid) && empty($kw)) header('Location:' . $MOD['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';

if(!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT.'/include/post.func.php';

$cateModel = new category();     //分类处理
$mallModule = baseModule::moduleInstance('mall');   //产品模块
$keywordModule = baseModule::moduleInstance('keyword'); //关键词
$mallQuery = new mallQuery();
$companyQuery = new CompanyQuery();

$pagesize = 15;
$page = isset($page) ? $page : 1;
$start = ($page - 1)*$pagesize;

$keyword = [];
if(empty($itemid)){
    $itemid = 0;
    $keyword['word'] = $kw;
}else{
    $wapurl = pc_to_wap::forword("chanpin/kw-$itemid-$page.html");        //跳转移动端
    $keyword = $keyword_db->field('word')->where(['itemid'=>$itemid])->one();
}
$selector = [];		//存放搜索条件
$selector['kwid'] = $itemid;
$selector['kw'] = $kw;

$condition =  [];  	//搜索条件
$condition['moduleid'] = $moduleid;
$condition['status'] = MallQuery::CHECKED_STATUS;

if(!empty($areaid)){
    $condition['areaid'] = $areaid;
    $selector['areaid'] = $areaid;
}

//云搜索相关产品id
$cSearch = new CloudSearch('tecenet');
$mallIds = $cSearch->setFilter($condition)
    ->setField(['itemid'])->setPageSize($pagesize)
    ->search($keyword['word'],$start);
$malls = [];

if(!empty($mallIds)){
    $ids = [];
    foreach($mallIds as $item){
        $ids[] = $item['itemid'];
    }
    $mallDb = new tcdb('mall');
    $malls = $mallDb->where(['itemid'=>implode(',',$ids)],'in')->all();     //搜索指定id的产品

    $scws = new scws();
    $stopWord = $scws->getStopWord();
    foreach($malls as $key => $value){
        $malls[$key]['title'] = str_replace($stopWord,'*',$value['title']);
    }

    $mallCount = $cSearch->getResultNum();

    //分页按钮
    $pagination = new pagination($page,$mallCount,$pagesize);
    $pagination->setModule($keywordModule);
    $pagination->setCurrentTip('class="on"');
    $paginationView = $pagination->show($MOD['linkurl'].'keyword.php',[
        'div' => ['class' => 'pagination'],
        'form' => ['id' => 'mallForm','method'=>'get'],
    ],$selector);
}

$keywordAnalysis = $keywordModule->getWordAnalysis($itemid);        //名词解析
$lkeyword = $keywordModule->getRecommendWord(10,$itemid);           //推荐关键词
$rmalls = $mallQuery->getRecommendMalls(6,0,30);                    //推荐产品
$nmalls = $mallQuery->getNewMalls(6);                               //最新产品
$rcompanys = $companyQuery->getRecommendCompanys(6);                //推荐企业

$action = 'keyword';

include template('keyword', $module);
?>
