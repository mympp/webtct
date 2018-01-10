<?php
use models\helpers\view\internalLink;

defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT . '/models/autoload.php';

//if($DT_BOT || $_POST) dhttp(403);
require DT_ROOT . '/module/' . $module . '/common.inc.php';
if (!check_group($_groupid, $MOD['group_search'])) include load('403.inc');
require DT_ROOT . '/include/post.func.php';
include load('search.lang');

//新版搜索功能
$pagesize = 15;
$page = empty($page) ? 1 : $page;
$start = ($page - 1) * $pagesize;
$buy_db = new tcdb('buy_6');

$condition['status'] = 3;
$inCondition = [];
$selector = [];

if (!empty($catid)) {
    $condition['catid'] = $catid;
    $selector['catid'] = $catid;
}

if (isset($typeid)) {
    $condition['typeid'] = $typeid;
    $selector['typeid'] = $typeid;
}

if (!empty($areaid)) {
    $selector['areaid'] = $areaid;
    $area = new tcdb('area');
    $childarea = $area->field('arrchildid,areaname,parentid')->where(['areaid' => $areaid])->one();
    $inCondition['areaid'] = $childarea['arrchildid'];
}

if (!empty($kw)) {
    $likeCondition['keyword'] = $kw;
    $selector['kw'] = $kw;
}

if (!empty($order) && $order == 'totime') {
    $order_str = 'totime desc';
} else {
    $order_str = 'itemid desc';
}

$lists = $buy_db->where($condition)->where($inCondition, 'in')
    ->likeWhere($likeCondition)->limit($start, $pagesize)->order($order_str)->select();

$condition_str = $buy_db->getCondition();
$count = $buy_db->where($condition_str)->count('c');

$seo_file = 'list';

$internalLink = new internalLink();
$internalLink->setModule(['mall', 'sell', 'sell1']);
$iLink = $internalLink->build($catid, $areaid, [
    'mall' => ['name' => '产品', 'titleName' => '产品'],
    'sell' => ['name' => '求购', 'titleName' => '求购', 'url' => ['typeid' => 1]],
    'sell1' => ['name' => '供应', 'url' => ['typeid' => 0], 'titleName' => '供应'],
]);

include DT_ROOT . '/include/seo.inc.php';
include template($MOD['template_search'] ? $MOD['template_search'] : 'search', $module);
?>