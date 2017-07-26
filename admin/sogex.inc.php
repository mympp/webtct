<?php
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
	array('返回sogex管理','?file='.$file),
    	//array('数据管理', '?file=sogex_info'),
   	 array('规则管理', '?file=sogex_rule'),
    	array('排名推广','?moduleid=3&file=spread'),
    	array('创意推广','?file=sogex_ideas'),
    	array('来源网站管理','?file=sogex_message'),
	array('标签管理','?file=sogex_tags'),
	array('搜索记录','?file=sogex_record'),
	array('更新缓存','?file=sogex_cache'),
);

$info_num3 = $db->get_one("select count(*) as c from {$db->pre}sogex_info where status = 3");
$info_num2 = $db->get_one("select count(*) as c from {$db->pre}sogex_info where status = 2");

include tpl($file);

?>
