<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MOD['vote_enable'] or dheader(DT_PATH);
require DT_ROOT.'/include/post.func.php';
$ext = 'vote';
$url = $EXT[$ext.'_url'];
$TYPE = get_type($ext, 1);
$_TP = sort_type($TYPE);
require MD_ROOT.'/'.$ext.'.class.php';
$do = new $ext();
$typeid = isset($typeid) ? intval($typeid) : 0;
$destoon_task = rand_task();
$UA = strtoupper($_SERVER['HTTP_USER_AGENT']);
if($itemid) {
	$do->itemid = $itemid;
	$item = $do->get_one();
	$item or dheader($url);
	extract($item);
	if ($item['status'] != 3) dalert('该投票未审核！', $url);
	$condition = $_username ? "AND username='$_username'" : "AND ip='$DT_IP'";
	$r = $db->get_one("SELECT rid FROM {$DT_PRE}vote_record WHERE itemid=$itemid $condition");
	if($submit) {		
		if($verify == 1) captcha($captcha, 1);
		if($verify == 2) question($answer, 1);
		$could_vote = true;
		if($r) $could_vote = false;
		if($fromtime && $DT_TIME < $fromtime) dalert('该投票还没开始！',$linkurl);
		if($totime && $DT_TIME > $totime) dalert('该投票已过期！',$linkurl);
		if(!check_group($_groupid, $MOD['vote_group'])) $could_vote = false;
		if($could_vote) {
			if ($vote) {
				$votes = count($vote);
				if($item['choose']) {					
					if($votes >= $vote_min && $votes <= $vote_max) {
						$v_arr = explode(',', $v);						
						foreach ($v_arr as $k => $v) {					
							if(in_array($k+1, $vote)) $v_arr[$k] = $v+1;															
						}
						$v = implode(',', $v_arr);						
						$db->query("UPDATE {$DT_PRE}vote SET votes=votes+{$votes},v='{$v}' WHERE itemid=$itemid");
						$i = implode(',', $vote);
						$db->query("INSERT INTO {$DT_PRE}vote_record (itemid,username,ip,votetime,votes) VALUES ('$itemid','$_username','$DT_IP','$DT_TIME','$i')");
						dalert('投票成功！', $linkurl);
					} else {
						dalert('最少选'.$vote_min.'项，最多选'.$vote_max.'项', $linkurl);
					}
				} else {
					if($votes == 1) {
						$v_arr = explode(',', $v);						
						foreach ($v_arr as $k => $v) {					
							if(in_array($k+1, $vote)) $v_arr[$k] = $v+1;															
						}
						$v = implode(',', $v_arr);
						$i = $vote[0];
						$db->query("UPDATE {$DT_PRE}vote SET votes=votes+1,v='{$v}' WHERE itemid=$itemid");
						$db->query("INSERT INTO {$DT_PRE}vote_record (itemid,username,ip,votetime,votes) VALUES ('$itemid','$_username','$DT_IP','$DT_TIME','$i')");
						// dheader($linkurl);
						dalert('投票成功！', $linkurl);
					}else {
						dalert('最多选1项', $linkurl);
					}
				}
			} else {
				dalert('请选择投票项', $linkurl);
			}			
		} else {
			dalert($L['vote_failed'], $linkurl);
		}
	}
	$content = strip_tags($content);
	$adddate = timetodate($addtime, 3);
	$fromdate = $fromtime ? timetodate($fromtime, 3) : $L['timeless'];
	$todate = $totime ? timetodate($totime, 3) : $L['timeless'];
	$votes = array();
	$e_arr = explode(',', $e);
	$p_arr = explode(',', $p);
	$s_arr = explode(',', $s);
	$v_arr = explode(',', $v);
	$j_arr = explode(',', $j);
	$x_arr = explode(',', $x);
	$j = 0;
	for($i = 0; $i < count($s_arr); $i++) {
		if($s_arr[$i]) {
			$votes[$i]['e'] = dsubstr($e_arr[$i],176);
			$votes[$i]['p'] = $p_arr[$i];
			$votes[$i]['title'] = $s_arr[$i];
			$votes[$i]['votes'] = $v_arr[$i];
			$votes[$i]['percent'] = $item['votes'] ? dround($v_arr[$i]*100/$item['votes'], 2, true).'%' : '0%';
			$votes[$i]['number'] = ++$j;
		}
	}
	$db->query("UPDATE {$DT_PRE}vote SET hits=hits+1 WHERE itemid=$itemid");
	$head_title = $head_keywords = $head_description = $title.$DT['seo_delimiter'].$L['vote_title'];
	$template = $item['template'] ? $item['template'] : $ext;
	if(!strpos($UA, 'WINDOWS NT')) {
		include template('vote', 'mobile');
	}else {
		include template($template, $module);
	}
} else {
	$head_title = $head_keywords = $head_description = $L['vote_title'];
	if($catid) $typeid = $catid;
	$condition = 'status = 3';
	if($typeid) {
		isset($TYPE[$typeid]) or dheader($url);
		$condition .= " AND typeid IN (".type_child($typeid, $TYPE).")";
		$head_title = $TYPE[$typeid]['typename'].$DT['seo_delimiter'].$head_title;
	}
	if($cityid) $condition .= ($AREA[$cityid]['child']) ? " AND areaid IN (".$AREA[$cityid]['arrchildid'].")" : " AND areaid=$cityid";
	$lists = $do->get_list($condition, 'addtime DESC');
	if(!strpos($UA, 'WINDOWS NT')) {
		include template('vote', 'mobile');
	}else {
		include template('vote', $module);
	}
}
?>