<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt1
*/
/*
time:2015/10/27
who ：xiaolv
rel : *.inc.php
update:63-75
*/
/*
time:2015/11/2
who ：xiaolv
升级：wap_output()、wap_pos()、unicode()、utf8_unicode()函数、80、82-89  v6.0无
update:31、34-35、40-43、54、71-76、91-92、95、99、103  增mobile_login()、input_trim()、toutf8()、video5()、video5_url()、video5_frame()、video5_player()函数
*/
defined('IN_DESTOON') or exit('Access Denied');
function wap_output() {
	global $EXT, $CFG;
	$data = ob_get_contents();
	ob_end_clean();
	if($EXT['wap_charset'] == 'unicode') {
		$data = unicode($data);
	} else {
		if(strtolower($CFG['charset'] != 'utf-8')) $data = convert($data, $CFG['charset'],  'utf-8');
	}
	echo $data;
}


function mobile_msg($msg, $forward = '') {
	if(!$msg && $forward) dheader($forward);
	extract($GLOBALS, EXTR_SKIP);
	include template('msg', 'mobile');
	if(DT_CHARSET != 'UTF-8') toutf8();
	wap_output();
	exit();
}

function mobile_login() {
	global $_userid, $DT_URL;
	$_userid or dheader('login.php?forward='.rawurlencode($DT_URL));
}

function wap_pos($CAT, $str = ' > ', $target = '') {
	global $moduleid, $db;
	if(!$CAT) return '';
	$arrparentids = $CAT['arrparentid'].','.$CAT['catid'];
	$arrparentid = explode(',', $arrparentids);
	$pos = '';
	$target = $target ? ' target="_blank"' : '';
	$CATEGORY = array();
	$result = $db->query("SELECT catid,moduleid,catname,linkurl FROM {$db->pre}category WHERE catid IN ($arrparentids)");
	while($r = $db->fetch_array($result)) {
		$CATEGORY[$r['catid']] = $r;
	}
	foreach($arrparentid as $catid) {
		if(!$catid || !isset($CATEGORY[$catid])) continue;
		$pos .= '<a href="?moduleid='.$moduleid.'&amp;catid='.$catid.'"'.$target.'>'.$CATEGORY[$catid]['catname'].'</a>'.$str;
	}
	return $pos;
}

//增加内分页下拉功能
function mobile_pages($total, $page = 1, $perpage = 20, $demo = '') {
	global $DT_URL, $DT, $CFG, $L;
	if($total <= $perpage) return '';
	$total = ceil($total/$perpage);
	$page = intval($page);
	if($page < 1 || $page > $total) $page = 1;
	if($demo) {
		$demo_url = $demo;
	} else {
		if(substr($DT_URL, -5) == '.html') {
			$demo_url = preg_replace("/[0-9]{1,}\.html/", "{destoon_page}.html", $DT_URL);
		} else {
			$demo_url = preg_replace("/(.*)([&?]page=[0-9]*)(.*)/i", "\\1\\3", $DT_URL);
			$s = strpos($demo_url, '?') === false ? '?' : '&';
			$demo_url = $demo_url.$s.'page={destoon_page}';
			$demo_url = str_replace('&', '&amp;', $demo_url);
			$demo_url = urldecode($demo_url);
			$pages = '<b>'.$page.'</b>/<select onchange="self.location.href=options[selectedIndex].value">';
			for ($i=1; $i <= $total; $i++) {
				$url = str_replace('{destoon_page}', $i, $demo_url);
				$pages .= '<option value="'.$url.'"';
				if($page == $i){
					$pages .= 'selected="selected"';
				}
				$pages .='>'.$i.'</option>';
			}
		}
		$pages = '<a href="javascript:GoPage('.$total.', \''.$demo_url.'\');"><b>'.$page.'</b>/'.$total.'</a> ';
		$_page = $page >= $total ? 1 : $page + 1;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= '<a href="'.$url.'" data-transition="none" id="page-next">'.$L['next_page'].'</a> ';

		$_page = $page <= 1 ? $total : ($page - 1);
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= '<a href="'.$url.'" data-transition="none" id="page-prev">'.$L['prev_page'].'</a> ';

		$_page = 1;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= '<a href="'.$url.'" data-transition="none" id="page-home">'.$L['home_page'].'</a> ';

		$_page = $total;
		$url = str_replace('{destoon_page}', $_page, $demo_url);
		$pages .= '<a href="'.$url.'" id="page-last">'.$L['last_page'].'</a> ';
		return $pages;
	}
}

function input_trim($wd) {
	return urldecode(str_replace('%E2%80%86', '', urlencode($wd)));
}

function toutf8() {
	$data = ob_get_contents();
	ob_end_clean();
	echo convert($data, DT_CHARSET, 'UTF-8');
}

function video5($content) {
	// $content = preg_replace("/\&([^;]+);/i", '', $content);
	// $content = nl2br($content);
	if(strpos($content, '</embed>') !== false) {
		if(!preg_match_all("/<embed[^>]*>(.*?)<\/embed>/i", $content, $matches)) return $content;
		foreach($matches[0] as $m) {
			$content = str_replace($m, video5_player(video5_url($m)), $content);
		}
		return $content;
	} else {
		return $content;
	}
}

function video5_url($content) {
	$url = '';
	if(strpos($content, 'vcastr3.swf') !== false) {
		$t1 = explode('source&gt;', $content);
		$url = str_replace('&lt;/', '', $t1[1]);
	} else if(strpos($content, 'src="') !== false) {
		$t1 = explode('src="', $content);
		$t2 = explode('"', $t1[1]);
		$url = $t2[0];
	}
	return $url;
}

function video5_frame($url, $w, $h) {
	return '<iframe src="'.$url.'" width="'.$w.'" height="'.$h.'" frameborder="0" scrolling="no" allowfullscreen="true" allowtransparency="true"></iframe>';
}

function video5_player($url, $w = 280, $h = 210, $a = 0) {
	$ext = file_ext($url);
	$u5 = '';
	if($ext == 'mp4') {
		$u5 = $url;
	} else if(strpos($url, '.youku.com') !== false) {
		if(strpos($url, '/sid/') !== false && strpos($url, '/v.sw') !== false) {
			$t1 = explode('/sid/', $url);
			$t2 = explode('/v.sw', $t1[1]);
			$t3 = $t2[0];
			if($t3) return video5_frame('http://player.youku.com/embed/'.$t3, $w, $h);
		}
	} else if(strpos($url, '.tudou.com') !== false) {
		if(strpos($url, '/v/') !== false) {
			$t1 = explode('/v/', $url);
			$t2 = explode('/', $t1[1]);
			$t3 = $t2[0];
			if($t3) return video5_frame('http://www.tudou.com/programs/view/html5embed.action?code='.$t3, $w, $h);
		}
	} else if(strpos($url, 'static.video.qq.com') !== false) {
		if(strpos($url, 'vid=') !== false) {
			$t1 = explode('vid=', $url);
			$t2 = explode('&', $t1[1]);
			$t3 = $t2[0];
			if($t3) return video5_frame('http://v.qq.com/iframe/player.html?vid='.$t3.'&tiny=0&auto=0', $w, $h);
		}
	} else if(strpos($url, '.56.com') !== false) {
		if(strpos($url, '/v_') !== false && strpos($url, '.sw') !== false) {
			$t1 = explode('/v_', $url);
			$t2 = explode('.sw', $t1[1]);
			$t3 = $t2[0];
			if($t3) return video5_frame('http://www.56.com/iframe/'.$t3, $w, $h);
		}
	} else if(strpos($url, '.ku6.com') !== false) {
		if(strpos($url, 'refer/') !== false && strpos($url, 'v.sw') !== false) {
			$t1 = explode('refer/', $url);
			$t2 = explode('v.sw', $t1[1]);
			$t3 = $t2[0];
			if($t3) $u5 = 'http://v.ku6.com/fetchwebm/'.$t3.'.m3u8';
		}
	} else if(strpos($url, '.youtube.com') !== false) {
		if(strpos($url, 'youtube.com/v/') !== false) {
			$t1 = explode('/v/', $url);
			$t3 = $t1[1];
			if($t3) return video5_frame('http://www.youtube.com/embed/'.$t3, $w, $h);
		}
	}
	if($u5) return '<video src="'.$u5.'" width="'.$w.'" height="'.$h.'"'.($a ? ' autoplay="autoplay"' : '').' controls="controls"></video><center><a href="'.$u5.'" target="_blank" rel="external">Click To Play</a></center>';
	return '';
}

function unicode($str) {
	global $CFG;
	$return = '';
	$step = strtolower($CFG['charset'] == 'utf-8') ? 3 : 2;
	while($str != '') {
		if(ord(substr($str, 0, 1)) > 127) {
			$return .= "&#x".dechex(utf8_unicode(convert(substr($str, 0, $step), $CFG['charset'],  'utf-8'))).";";
			$str = substr($str, $step, strlen($str));
		} else {
			$return .= substr($str, 0, 1);
			$str = substr($str, 1, strlen($str));
		}
	}
	return $return;
}

function utf8_unicode($chr) {
	switch(strlen($chr)) {
		case 1:
			return ord($chr);
		break;
		case 2:
			$n = (ord($chr[0]) & 0x3f) << 6;
			$n += ord($chr[1]) & 0x3f;
			return $n;
		break;
		case 3:
			$n = (ord($chr[0]) & 0x1f) << 12;
			$n += (ord($chr[1]) & 0x3f) << 6;
			$n += ord($chr[2]) & 0x3f;
			return $n;
		break;
		case 4:
			$n = (ord($chr[0]) & 0x0f) << 18;
			$n += (ord($chr[1]) & 0x3f) << 12;
			$n += (ord($chr[2]) & 0x3f) << 6;
			$n += ord($chr[3]) & 0x3f;
			return $n;
		break;
	}
}
function companyurl($moduleid, $username = 0, $itemid = 0, $page = 1) {//企业网址伪静态
	if(RE_WRITE) return $moduleid.'-'.$username.'-'.$itemid.'-'.$page.'-'.$action.'.html';
	if($itemid) {
		return 'index.php?moduleid='.$moduleid.'&itemid='.$itemid.($page > 1 ? '&page='.$page : '');
	} else if($username) {
		return 'index.php?moduleid='.$moduleid.'&username='.$username.($page > 1 ? '&page='.$page : '');
	} else {
		return 'index.php?moduleid='.$moduleid.($page > 1 ? '&page='.$page : '');
	}
}

function homepageurl($moduleid=4,$username, $action) {//企业网站模块伪静态
		return 'index.php?moduleid='.$moduleid.'&username='.$username.'&action='.$action.($page > 1 ? '&page='.$page : '');
}


?>