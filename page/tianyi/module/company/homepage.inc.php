<?php
defined('IN_DESTOON') or exit('Access Denied');
$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $DT_PRE.'company_data');
$table_honor = $DT_PRE.'honor';
$table_mall = $DT_PRE.'mall';
$table_tycase = $DT_PRE.'tycase';
$r = $db->get_one("SELECT content FROM {$content_table} WHERE userid=$userid");
$COM['content'] = $r['content'];
$intro_length = isset($HOME['intro_length']) && $HOME['intro_length'] ? intval($HOME['intro_length']) : 1000;
$COM['intro'] = nl2br(dsubstr(trim(strip_tags($r['content'])), $intro_length, '...'));
$COM['thumb'] = $COM['thumb'] ? $COM['thumb'] : DT_SKIN.'image/company.jpg';
if($COMGROUP['main_d']) {
	$_main_show = array();
	foreach($HMAIN as $k=>$v) {
		$_main_show[$k] = strpos(','.$COMGROUP['main_d'].',', ','.$k.',') !== false ? 1 : 0;
	}
	$_main_show = implode(',', $_main_show);
} else {
	$_main_show = '1,1,1,0,0,0,0';
}
$_main_order = '0,10,20,30,40,50,60,70';
$_main_num = '10,1,10,5,3,4,4,10';
$_main_file= implode(',' , $IFILE);
$_main_name = implode(',' , $HMAIN);

$main_show = explode(',', isset($HOME['main_show']) ? $HOME['main_show'] : $_main_show);
$main_order = explode(',', isset($HOME['main_order']) ? $HOME['main_order'] : $_main_order);
$main_num = explode(',', isset($HOME['main_num']) ? $HOME['main_num'] : $_main_num);
$main_file = explode(',', isset($HOME['main_file']) ? $HOME['main_file'] : $_main_file);
$main_name = explode(',', isset($HOME['main_name']) ? $HOME['main_name'] : $_main_name);
$_HMAIN = array();
asort($main_order);
foreach($main_order as $k=>$v) {
	if($main_show[$k] && in_array($main_file[$k], $IFILE)) {
		$_HMAIN[$k] = $HMAIN[$k];
	}
	if($main_num[$k] < 1 || $main_num[$k] > 50) $main_num[$k] = 10;
}
$HMAIN = $_HMAIN;
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username;
$seo_title = isset($HOME['seo_title']) && $HOME['seo_title'] ? $HOME['seo_title'] : '';
$head_title = '';


//企业简介正则去掉图片
$notimgcontent=preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i','',$COM['content']);

//更多链接
foreach($MENU as &$url){
	if($url['name']=='公司简介'){
		$introduceurl=$url['linkurl'];
	}elseif($url['name']=='产品展示'){
		$mallurl=$url['linkurl'];
	}elseif($url['name']=='项目案例'){
		$tycaseurl=$url['linkurl'];
	}elseif($url['name']=='联系方式'){
		$contacturl=$url['linkurl'];
	}
}

$condition = "username='$username' AND status=3";

//荣誉资质
$honor = $db->query("SELECT * FROM {$table_honor} WHERE $condition ORDER BY addtime DESC");
$honor_list = array();
while($r = $db->fetch_array($honor)) {
	$r['title'] = $r['title'];
	$r['image'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
	$honor_list[] = $r;
}
$db->free_result($honor);

//产品
$mall = $db->query("SELECT * FROM {$table_mall} WHERE $condition  ORDER BY addtime DESC LIMIT 1,15");
$mall_list = array();
while($r = $db->fetch_array($mall)) {
	$r['title'] = $r['title'];
	$r['linkurl'] = DT_PATH."mall/show.php?itemid=$r[itemid]";
	$r['image'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
	$mall_list[] = $r;
}
$db->free_result($mall);

//项目案例
$tycase = $db->query("SELECT * FROM {$table_tycase} WHERE $condition ORDER BY addtime DESC LIMIT 1,9");
$tycase_list = array();
while($r = $db->fetch_array($tycase)) {
	$r['title'] = $r['title'];
	$r['content'] = $r['content'];
	$r['image'] = str_replace('.thumb.'.file_ext($r['thumb']), '', $r['thumb']);
	$tycase_list[] = $r;
}
$db->free_result($tycase);

//地图
$CS = cache_read('module-4.php');
$api_map = $CS['map'];
include template('index', $template);
if(isset($update) && $db->cache_ids && ($username == $_username || $_groupid == 1 || $domain)) {
	foreach($db->cache_ids as $v) {
		$dc->rm($v);
	}
	dheader($COM['linkurl']);
}
//echo '<pre />';
?>