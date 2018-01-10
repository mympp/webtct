<?php
use models\helpers\view\internalLink;
use models\helpers\widget\nlp\scws;

defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT . '/models/autoload.php';

$itemid or dheader($MOD['linkurl']);
if (!check_group($_groupid, $MOD['group_show'])) include load('403.inc');
require DT_ROOT . '/module/' . $module . '/common.inc.php';
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
$adddate = timetodate($addtime, 5);
$editdate = timetodate($edittime, 5);
$todate = $totime ? timetodate($totime, 3) : 0;
$expired = $totime && $totime < $DT_TIME ? true : false;
$linkurl = $MOD['linkurl'] . $linkurl;
$thumbs = get_albums($item);
$albums = get_albums($item, 1);
$amount = number_format($amount, 0, '.', '');
$fee = get_fee($item['fee'], $MOD['fee_view']);
$update = '';
if (check_group($_groupid, $MOD['group_contact'])) {
    if ($fee) {
        $user_status = 4;
        //$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
    } else {
        $user_status = 3;
        $member = $item['username'] ? userinfo($item['username']) : array();
        if ($item['totime'] && $item['totime'] < $DT_TIME && $item['status'] == 3) {
            $update .= ",status=4";
            $db->query("UPDATE {$table_search} SET status=4 WHERE itemid=$itemid");
        }
        if ($member && $member['groupid'] > 6) {
            foreach (array('groupid', 'vip', 'validated', 'company', 'areaid', 'truename', 'telephone', 'mobile', 'address', 'qq', 'msn', 'ali', 'skype') as $v) {
                if ($item[$v] != $member[$v]) $update .= ",$v='" . addslashes($member[$v]) . "'";
            }
            if ($item['email'] != $member['mail']) $update .= ",email='$member[mail]'";
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
$seo_file = 'show';
include DT_ROOT . '/include/seo.inc.php';
if ($EXT['wap_enable']) $head_mobile = $EXT['wap_url'] . 'index.php?moduleid=' . $moduleid . '&itemid=' . $itemid . ($page > 1 ? '&page=' . $page : '');
if ($EXT['wap_enable']) $head_mobile = '';

require_once DT_ROOT . '/include/tcdb.class.php';
$sell = new tcdb('sell_5');
//增加点击统计
$nhits = (int)$hits + 1;
$sell->where(['itemid' => $itemid])->edit(['hits' => $nhits]);

//绑定详细页面模板

$internalLink = new internalLink();
$internalLink->setModule(['company', 'sell', 'mall']);
if (empty($template)) {
    if ($typeid == 1) {
        $iLink = $internalLink->build($catid, $areaid, [
            'company' => ['name' => '企业'],
            'sell' => ['name' => '供应', 'url' => ['typeid' => 0]],
            'mall' => ['name' => '产品'],
        ]);
        $template = 'show';
    } else {
        $iLink = $internalLink->build($catid, $areaid, [
            'company' => ['name' => '企业'],
            'sell' => ['name' => '求购', 'url' => ['typeid' => 1]],
            'mall' => ['name' => '产品'],
        ]);
        $template = 'show-gong';
    }
}
//提取分类内容数据

$category = new tcdb('category');
$maincat = $category->field('catid,catname')->where(['moduleid' => 5, 'parentid' => 0])->all();
$CATEGORY = [];
foreach ($maincat as $k => $v) {
    $CATEGORY[$v['catid']] = $v['catname'];
}

//过滤敏感词
$scws = new scws();
$stopWord = $scws->getStopWord();
$content = str_replace($stopWord , '*',$content);
$title = str_replace($stopWord , '*',$title);

include template($template, $module);
?>
