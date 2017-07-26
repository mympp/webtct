<?php 
require 'config.inc.php';
require '../common.inc.php';
/*
who:chentao
when:2016-3-14
what:添加过滤词判断
where:见--2016/4/26/chentao--
*/
//--2016/4/26/chentao--start
if($submit) {
	check_post() or dalert($L['bad_data']);//safe
	$BANWORD = cache_read('banword.php');
	if($BANWORD && isset($setting)) {
		$keys = array('seo_title', 'seo_keywords','seo_description');
		foreach($keys as $value) {
			if(isset($setting[$value])){ 
				$string = stripslashes($setting[$value]);
				foreach($BANWORD as $v) {
				$v[0] = preg_quote($v[0]);
				$v[0] = str_replace('/', '\/', $v[0]);
				$v[0] = str_replace("\*", ".*", $v[0]);
				if($v[2]) {
					if(preg_match("/".$v[0]."/i", $string)) dalert('"'.$v[0].'" 被网站禁止使用',$MOD['linkurl'].'home.php');
				}
		}
			}
		}
	}
}
//--2016/4/26/chentao--end

require DT_ROOT.'/module/'.$module.'/home.inc.php';


?>