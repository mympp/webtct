<?php
defined('IN_DESTOON') or exit('Access Denied');
use models\helpers\widget\nlp\scws;

require_once DT_ROOT .'/models/autoload.php';

$content_table = content_table(4, $userid, is_file(DT_CACHE . '/4.part'), $DT_PRE . 'company_data');
$r = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
$COM['content'] = $r['content'];
$intro_length = isset($HOME['intro_length']) && $HOME['intro_length'] ? intval($HOME['intro_length']) : 1000;
$COM['intro'] = nl2br(dsubstr(trim(strip_tags($r['content'])), $intro_length, '...'));
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN . 'image/company.jpg';
if ($COMGROUP['main_d']) {
    $_main_show = array();
    foreach ($HMAIN as $k => $v) {
        $_main_show[$k] = strpos(',' . $COMGROUP['main_d'] . ',', ',' . $k . ',') !== false ? 1 : 0;
    }
    $_main_show = implode(',', $_main_show);
} else {
    $_main_show = '1,1,1,0,0,0,0';
}
$_main_order = '0,10,20,30,40,50,60,70,80,90,100';
$_main_num = '10,1,10,5,3,4,4,10,1,1,1';
$_main_file = implode(',', $IFILE);
$_main_name = implode(',', $HMAIN);

$main_show = explode(',', isset($HOME['main_show']) ? $HOME['main_show'] : $_main_show);
$main_order = explode(',', isset($HOME['main_order']) ? $HOME['main_order'] : $_main_order);
$main_num = explode(',', isset($HOME['main_num']) ? $HOME['main_num'] : $_main_num);
$main_file = explode(',', isset($HOME['main_file']) ? $HOME['main_file'] : $_main_file);
$main_name = explode(',', isset($HOME['main_name']) ? $HOME['main_name'] : $_main_name);
$_HMAIN = array();
asort($main_order);
foreach ($main_order as $k => $v) {
    if ($main_show[$k] && in_array($main_file[$k], $IFILE)) {
        $_HMAIN[$k] = $HMAIN[$k];
    }
    if ($main_num[$k] < 1 || $main_num[$k] > 50) $main_num[$k] = 10;
}
$HMAIN = $_HMAIN;
if ($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'] . 'index.php?moduleid=4&username=' . $username;
$seo_title = isset($HOME['seo_title']) && $HOME['seo_title'] ? $HOME['seo_title'] : '';
$head_title = '';

//$db->query("update {$db->pre}company set hits = (hits + 1) where username = '$username'");
$new_hits = (int)$COM['hits'] + 1;
$db->query("update {$db->pre}company set hits = $new_hits where userid = '" . $COM['userid'] . "'");

//过滤敏感词
$scws = new scws();
$stopWord = $scws->getStopWord();
$COM['intro'] = str_replace($stopWord,'*',$COM['intro']);
$COM['btitle'] = str_replace($stopWord,'*',$COM['btitle']);

include template('index', $template);

?>