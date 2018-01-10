<?php
use models\helpers\view\internalLink;
use models\helpers\widget\nlp\scws;

defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT . '/models/autoload.php';

//if($_POST) dhttp(403);
require DT_ROOT . '/module/' . $module . '/common.inc.php';
if (!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT . '/include/post.func.php';
require DT_ROOT . '/include/tcdb.class.php';
include load('search.lang');

//分类数据
$category_db = new tcdb('category');
$CAT = $category_db->where(['moduleid' => 5])->all();
$CATEGORY = [];
foreach ($CAT as $k => $v) {
    $CATEGORY[$v['catid']] = $v['catname'];
}
$CATEGRORY[0] = '医疗器械';
//需求类型
$TYPE[0] = '供应';
$TYPE[1] = '需求';
$TYPE[2] = '其他';
$nowtime = strtotime(date('Y-m-d', time())); //当日0时时间戳
//搜索条件
$selector = [];        //存放搜索条件
$condition = $inCondition = $gtCondition = $likeCondition = [];
$order_str = '';
$pagesize = 20;
$typeid = isset($typeid) ? $typeid : 0;
$condition['status'] = 3;
if (isset($catid) && !empty($catid)) {
    $selector['catid'] = $catid;
    $condition['catid'] = $catid;
}
$selector['typeid'] = $typeid;
$condition['typeid'] = $typeid;
if ($typeid == 1) $pagesize = 12;
if (isset($areaid) && !empty($areaid)) {
    $selector['areaid'] = $areaid;
    $area = new tcdb('area');
    $childarea = $area->field('arrchildid,areaname,parentid')->where(['areaid' => $areaid])->one();
    $inCondition['areaid'] = $childarea['arrchildid'];
}
if (isset($day) && !empty($day)) {
    $selector['day'] = $day;
    $gtCondition['addtime'] = $nowtime - (3600 * 24 * $day);
}
if (isset($validated) && !empty($validated)) {
    $selector['validated'] = $validated;
    $gtCondition['validated'] = 0;
}
if (isset($order) && !empty($order)) {
    $selector['order'] = $order;
    $order_str = $order . ' desc';
} else {
    $order_str = 'vip desc,itemid desc';
}
if (isset($kw) && !empty($kw)) {
    $selector['kw'] = $kw;
    $likeCondition['keyword'] = $kw;
}

$sell = new tcdb('sell_5');
$page = isset($page) ? $page : 1;
$start = ($page - 1) * $pagesize;
$sell->where($condition)->where($inCondition, 'in')->where($gtCondition, '>')->likeWhere($likeCondition);
$condition_str = $sell->condition;
$lists = $sell->field('itemid,linkurl,thumb,title,price,unit,amount,hits,areaid,validated,vip,email,mobile,addtime,catid,totime')
    ->limit($start, $pagesize)->order($order_str)->select();
//过滤敏感词
$scws = new scws();
$stopWord = $scws->getStopWord();
foreach ($lists as $key => $value) {
    $lists[$key]['title'] = str_replace($stopWord, '*', $value['title']);
}
$items = $sell->field('count(*) as c')->where(str_replace('where', '', $condition_str))->one();

$internalLink = new internalLink();
$internalLink->setModule(['company', 'sell', 'mall']);
if ($typeid == 1) {
    $iLink = $internalLink->build($catid, $areaid, [
        'company' => ['name' => '企业'],
        'sell' => ['name' => '供应', 'url' => ['typeid' => 0]],
        'mall' => ['name' => '产品'],
    ]);
} else {
    $iLink = $internalLink->build($catid, $areaid, [
        'company' => ['name' => '企业'],
        'sell' => ['name' => '求购', 'url' => ['typeid' => 1]],
        'mall' => ['name' => '产品'],
    ]);
}


$seo_file = 'list';            //使用后台设置列表seo信息作为seo内容
include DT_ROOT . '/include/seo.inc.php';
include template('search', $module);
?>