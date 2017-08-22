<?php
defined('DT_ADMIN') or exit('Access Denied');

if($action == 'sitemaps') {
	var_dump($module);exit;
	tohtml('sitemaps', $module);
	msg('SiteMaps 更新成功', '?moduleid='.$moduleid.'&file=setting#sitemaps');
} else if($action == 'baidunews') {
	tohtml('baidunews', $module);
	msg('BaiduNews 更新成功', '?moduleid='.$moduleid.'&file=setting#baidunews');
}
?>