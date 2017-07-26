<?php 
require 'config.inc.php';
require '../common.inc.php';

/*
who:chentao
when:2016-3-28
what:添加过滤词判断,过滤不适当公司名
where:见--2016/3/28/chentao--
*/
//--2016/3/28/chentao--start
if($submit) {
	check_post() or dalert($L['bad_data']);//safe
	$BANWORD = cache_read('banword.php');
	if($BANWORD && isset($post)) {
		$keys = array('company');
		foreach($keys as $value) {
			if(isset($post[$value])){ 
				$string = stripslashes($post[$value]);
				foreach($BANWORD as $v) {
				$v[0] = preg_quote($v[0]);
				$v[0] = str_replace('/', '\/', $v[0]);
				$v[0] = str_replace("\*", ".*", $v[0]);
				if($v[2]) {
					if(preg_match("/".$v[0]."/i", $string)) dalert('"'.$v[0].'" 被网站禁止使用');
				}
		}
			}
		}
	}
}
//--2016/3/28/chentao--end

require DT_ROOT.'/module/'.$module.'/register.inc.php';
?>