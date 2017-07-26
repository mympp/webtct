<?php 
require 'config.inc.php';
require '../common.inc.php';

/*
who:chentao
when:2016-9-29
what:添加过滤词判断,过滤不适当公司名,附言和联系人姓名
where:见--2016/9/29/chentao--
*/
//--2016/9/29/chentao--start
if($submit) {
	check_post() or dalert($L['bad_data']);//safe
	$BANWORD = cache_read('banword.php');
	if($BANWORD && isset($company) && isset($truename)) {
		$keys = array('company'=>$company,'truename'=>$truename,'content'=>$content);
		foreach($keys as $value) {
			if(isset($value)){ 
				$string = stripslashes($value);
				foreach($BANWORD as $v) {
				$v[0] = preg_quote($v[0]);
				$v[0] = str_replace('/', '\/', $v[0]);
				$v[0] = str_replace("\*", ".*", $v[0]);
				if($v[2]) {
					if(preg_match("/".$v[0]."/i", $string)) dalert('"'.$v[0].'" 被网站禁止使用','grade.php?action=grade&sj=yes&groupid=6&kd=1#UP');
				}
		}
			}
		}
	}
}
//--2016/9/29/chentao--end

require DT_ROOT.'/module/'.$module.'/grade.inc.php';
?>