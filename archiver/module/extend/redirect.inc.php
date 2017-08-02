<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$url = isset($url) ? fix_link($url) : DT_PATH;
$url = str_replace("\t","",$url);
$url = str_replace("\r\n","",$url);
$url = str_replace("\r","",$url);
$url = str_replace("\n","",$url);
$url = str_replace(" ","",$url);
$url = str_replace("'","",$url);
//echo $url;
//exit;
if(isset($username)) {
	if(check_name($username)) {
		$r = $db->get_one("SELECT linkurl FROM {$DT_PRE}company WHERE username='$username'");
		$url = $r ? $r['linkurl'] : userurl($username);
	}
} else if(isset($aid)) {
	$aid = intval($aid);
	if($aid) {
		$r = $db->get_one("SELECT url,key_moduleid,key_id,typeid FROM {$DT_PRE}ad WHERE aid=$aid AND fromtime<$DT_TIME AND totime>$DT_TIME");
		if($r) {
			$url = ($r['key_moduleid'] && $r['typeid'] > 5) ? 'redirect.php?mid='.$r['key_moduleid'].'&itemid='.$r['key_id'] : $r['url'];
			$db->query("UPDATE {$DT_PRE}ad SET hits=hits+1 WHERE aid=$aid");
		}
	}
} else if($mid) {
	if(isset($MODULE[$mid]) && $itemid) {
		if($mid == 2) $mid = 4;
		$condition = $mid == 4 ? "userid=$itemid" : "itemid=$itemid";
		$r = $db->get_one("SELECT linkurl FROM ".get_table($mid)." WHERE $condition");
		if($r) {
			$url = strpos($r['linkurl'], '://') === false ? $MODULE[$mid]['linkurl'].$r['linkurl'] : $r['linkurl'];
		}
	}
	if($mid == -9 && $itemid) $url = $MODULE[9]['linkurl'].rewrite('resume.php?itemid='.$itemid);
} else {
	check_referer() or $url = DT_PATH;
}
	if(stripos('http://'.$url,DT_PATH)){
	// 本站链接直接跳转
	dheader($url);
	}
	else{
	echo "<div style='font-size:12px;'><h2>提示：此链接非<a href='".DT_PATH."'>".$DT['sitename']."</a>的站内链接。</h2>请注意安全!<br>仍然要打开，请点击以下网址:<br><a href='".$url."' target=_blank>".$url."</a></div>";
	}
?>