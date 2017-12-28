<?php
use models\helpers\view\internalLink;
use models\helpers\widget\nlp\scws;
use models\helpers\widget\redirect\pc_to_wap;
use models\extensions\opensearch\CloudSearch;
use models\helpers\data\tcdb;

defined('IN_DESTOON') or exit('Access Denied');

$itemid or dheader($MOD['linkurl']);
if (!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT . '/module/' . $module . '/common.inc.php';

//跳转移动端
$wapurl = pc_to_wap::forword('chanpin/show-' . $itemid . '.html');

$item = $db->get_one("SELECT * FROM {$table} WHERE itemid=$itemid");
if ($item['groupid'] == 2) include load('404.inc');
if ($item && $item['status'] > 2) {
    if ($MOD['show_html'] && is_file(DT_ROOT . '/' . $MOD['moduledir'] . '/' . $item['linkurl'])) d301($MOD['linkurl'] . $item['linkurl']);
    extract($item);
} else {
    include load('404.inc');
}
$CAT = get_cat($catid);
if (!check_group($_groupid, $CAT['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if ($lazy) $content = img_lazy($content);
if ($MOD['keylink']) $content = keylink($content, $moduleid);
$CP = $MOD['cat_property'] && $CAT['property'];
if ($CP) {
    require DT_ROOT . '/include/property.func.php';
    $options = property_option($catid);
    $values = property_value($moduleid, $itemid);
}
$RL = $relate_id ? get_relate($item) : array();
$P1 = get_nv($n1, $v1);
$P2 = get_nv($n2, $v2);
$P3 = get_nv($n3, $v3);
if ($step) {
    extract(unserialize($step));
} else {
    $a1 = 1;
    $p1 = $item['price'];
    $a2 = $a3 = $p2 = $p3 = '';
}
$unit or $unit = $L['unit'];
$adddate = timetodate($addtime, 3);
$editdate = timetodate($edittime, 3);
$linkurl = $MOD['linkurl'] . $linkurl;
$thumbs = get_albums($item);
$albums = get_albums($item, 0);        //修改产品详细页展示图片为thumb中缀的图片
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if (check_group($_groupid, $MOD['group_contact'])) {
    if ($fee) {
        $user_status = 4;
        $destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
    } else {
        $user_status = 3;
        $member = $item['username'] ? userinfo($item['username']) : array();
        if ($member && $member['groupid'] > 5) {
            $update_user = update_user($member, $item);
            if ($update_user) $db->query("UPDATE {$table} SET " . substr($update_user, 1) . " WHERE username='$username'");
        }
    }
} else {
    $user_status = $_userid ? 1 : 0;
    if ($_username && $item['username'] == $_username) {
        $member = userinfo($item['username']);
        $user_status = 3;
    }
}
include DT_ROOT . '/include/update.inc.php';

/**
 * 新版详细页增加内容
 */

$mall_db = new tcdb('mall');
$item = $mall_db->field('kcatids')->where(['itemid' => $itemid, 'status' => 3])->one();        //补充查询产品信息
if (!$item) include load('404.inc');

//相关科室数据
if (!empty($item['kcatids'])) {
    $kcatids = substr($item['kcatids'], 0, -1);
    $keshis = $category_db->field('catid,catname')->where(['moduleid' => 12])->where(['catid' => $kcatids], 'in')->all();
    foreach ($keshis as $k => $v) {
        $KESHI[$v['catid']] = $v['catname'];
    }
}
//企业信息
$company_db = new tcdb('company');
$company = $company_db->field('userid,mode,linkurl,telephone,mail,company')->where(['username' => $username])->one();
$company_data_db = new tcdb('company_data');
$comany_introduce = $company_data_db->field('content')->where(['userid' => $company['userid']])->one();

$word = $title;
$scws = new scws($title);
if ($scws->checkScwsExist()) {
    $word_arr = $scws->getSegByAttr('n');
    $word = implode(' ', $word_arr);
}

$cSearch = new CloudSearch('tecenet');
$cSearch->setFilter(['moduleid' => $moduleid]);
$cSearch->setFilter(['status' => 3]);
$cSearch->setField(['itemid', 'linkurl', 'thumb', 'title']);
$cSearch->setPageSize(8);
$malldata = $cSearch->search($word);

if (count($malldata) < 2) {
    if (!empty($word_arr[0])) {
        $malldata = $cSearch->search($word_arr[0]);
    } else {
        unset($malldata);
    }
}

//相关搜索词
$keyword_data_db = new tcdb('keyword_data');
$simword = $keyword_data_db->field('itemid,word')->order('itemid asc')->limit(rand(0, 90), 10)->select();
//猜你喜欢产品
$likemall = $mall_db->field('title,thumb,linkurl,kcatids,company,username')->where(['status' => 3, 'catid' => $catid])->where(['thumb' => ''], '<>')->order('itemid desc')->limit(0, 6)->select();

$internalLink = new internalLink();
$internalLink->setModule(['mall', 'keshi', 'buy']);
$iLink = $internalLink->build($catid, $areaid, [
    'mall' => ['name' => '产品', 'titleName' => '产品'],
    'keshi' => ['name' => '医疗器械', 'titleName' => '科室']
]);

$seo_file = 'show';
include DT_ROOT . '/include/seo.inc.php';
if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . mobileurl($moduleid, 0, $itemid, $page);
$template = $item['template'] ? $item['template'] : ($CAT['show_template'] ? $CAT['show_template'] : 'show');
include template($template, $module);


?>
