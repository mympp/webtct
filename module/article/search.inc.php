<?php
use models\helpers\view\internalLink;
use models\helpers\widget\nlp\scws;

defined('IN_DESTOON') or exit('Access Denied');

//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT . '/module/' . $module . '/common.inc.php';
if (!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT . '/include/post.func.php';

$condition['status'] = 3;
$selector = [];
//改版新功能流程
if (!empty($u)) {
    $category_db = new tcdb('category');
    $CAT = $category_db->where(['catdir' => $u, 'moduleid' => 21])->one();
    if (empty($CAT)) {
        header('Location:' . $MODULE[21]['linkurl']);
        exit;
    } else {
        $catid = $CAT['catid'];
    }
}

if (!empty($catid) && empty($CAT)) {
    $category_db = new tcdb('category');
    $CAT = $category_db->where(['catid' => $catid])->one();
    if (empty($CAT)) {
        header('Location:' . $MODULE[21]['linkurl']);
        exit;
    }
}
$catid = isset($catid) ? $catid : '';
if (!empty($catid)) {
    $condition['catid'] = $catid;
    $selector['catid'] = $catid;
}

$catname = empty($CAT) ? '天成资讯' : $CAT['catname'];

$likeCondition = [];
if (!empty($kw)) {
    $likeCondition['keyword'] = $kw;
    $selector['kw'] = $kw;
}

$page = isset($page) ? $page : 1;
$pagesize = 12;
$start = ($page - 1) * $pagesize;
$article_db = new tcdb('article_21');
$lists = $article_db->field('itemid,title,introduce,addtime,linkurl,thumb,copyfrom,hits')
    ->where($condition)->likeWhere($likeCondition)->order('itemid desc')->limit($start, $pagesize)->select();
$scws = new scws();
$stopWord = $scws->getStopWord();
foreach($lists as $key => $value){
    $lists[$key]['title'] = str_replace($stopWord, '*',$value['title']);
}
$items = $article_db->where($article_db->getCondition())->count('c');

$internalLink = new internalLink();
$internalLink->setModule(['mall', 'article', 'company']);
$iLink = $internalLink->build($catid, $areaid, [
    'mall' => ['name' => '产品', 'titleName' => '产品'],
    'article' => ['name' => '资讯', 'titleName' => '资讯', 'closeArea' => true],
    'company' => ['name' => '企业', 'url' => ['typeid' => 0], 'titleName' => '企业'],
]);

//页面右侧内容
$recommendArticles = getRecommendArticles();
$hitsArticles = getTopHitsArticle($catid, 7);

$seo_file = 'list';
include DT_ROOT . '/include/seo.inc.php';
include template($MOD['template_search'] ? $MOD['template_search'] : 'search', $module);


?>