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
$itemcat = get_cat($catid);
if (!check_group($_groupid, $itemcat['group_show'])) include load('403.inc');
$content_table = content_table($moduleid, $itemid, $MOD['split'], $table_data);
$t = $db->get_one("SELECT content FROM {$content_table} WHERE itemid=$itemid");
$content = $t['content'];
if ($lazy) $content = img_lazy($content);
if ($MOD['keylink']) $content = keylink($content, $moduleid);

$CP = $MOD['cat_property'] && $itemcat['property'];
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
$update = '';
$fee = get_fee($item['fee'], $MOD['fee_view']);
if (check_group($_groupid, $MOD['group_contact'])) {
    if ($fee) {
        $user_status = 4;
        //$destoon_task = "moduleid=$moduleid&html=show&itemid=$itemid";
    } else {
        $user_status = 3;
        //不自动更新用户信息
        //$member = $item['username'] ? userinfo($item['username']) : array();
        //if($item['totime'] && $item['totime'] < $DT_TIME && $item['status'] == 3) $update .= ",status=4";
        //if($member) {
        //	$update_user = update_user($member, $item);
        //	if($update_user) $db->query("UPDATE {$table} SET ".substr($update_user, 1)." WHERE username='$username'");
        //}
    }
} else {
    $user_status = $_userid ? 1 : 0;
    if ($_username && $item['username'] == $_username) {
        $member = userinfo($item['username']);
        $user_status = 3;
    }
}

//增加点击次数
require_once DT_ROOT . '/include/tcdb.class.php';
$buy_db = new tcdb('buy_6');
$buy_db->where(['itemid' => $itemid])->edit(['hits' => ($hits + 1)]);

//正文敏感词过滤
$scws = new scws();
if($scws->checkScwsExist()){
    $content = str_replace($scws->getStopWord(),'*',$content);
}

$seo_file = 'show';
include DT_ROOT . '/include/seo.inc.php';
if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . mobileurl($moduleid, 0, $itemid, $page);
if ($EXT['wap_enable']) $head_mobile = '';
$template = 'show';
if ($MOD['template_show']) $template = $MOD['template_show'];
if ($CAT['show_template']) $template = $CAT['show_template'];
if ($item['template']) $template = $item['template'];

$internalLink = new internalLink();
$internalLink->setModule(['mall', 'sell', 'sell1']);
$iLink = $internalLink->build($catid, $areaid, [
    'mall' => ['name' => '产品', 'titleName' => '产品'],
    'sell' => ['name' => '求购', 'titleName' => '求购', 'url' => ['typeid' => 1]],
    'sell1' => ['name' => '供应', 'url' => ['typeid' => 0], 'titleName' => '供应'],
]);

include template('show', $module);
?>