<?php 
/*
who:chentao
when:2015-10-26
where:行26-46
what:科技网首页数据查询
relation:/template/tc/quote/index.php
*/
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
/*if($MOD['index_html']) {	
	$html_file = DT_ROOT.'/'.$MOD['moduledir'].'/'.$DT['index'].'.'.$DT['file_ext'];
	if(!is_file($html_file)) tohtml('index', $module);
	if(is_file($html_file)) exit(include($html_file));
}*/
if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
$destoon_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);


require MD_ROOT.'/quote.class.php';
$do = new quote($moduleid);

//搜索子类型
$project_child_catid=$db->get_one("select arrchildid as child from {$db->pre}category where catid={$project_catid}");
$clinic_child_catid=$db->get_one("select arrchildid as child from {$db->pre}category where catid={$clinic_catid}");

//统计所有类型的数目
$count_project_need=$db->get_one("select count(*) as num from {$do->table} where stype=1 and status=3 and catid in ($project_child_catid[child])");
$count_project_supply=$db->get_one("select count(*) as num from {$do->table} where stype=0 and status=3 and catid in ($project_child_catid[child])");
$count_clinic_need=$db->get_one("select count(*) as num from {$do->table} where stype=1 and status=3 and catid in ($clinic_child_catid[child])");
$count_clinic_supply=$db->get_one("select count(*) as num from {$do->table} where stype=0 and status=3 and catid in ($clinic_child_catid[child])");

$qixie_arr=array();  //器械类别
$qixie_arr[0]='不限';
$qixie_arr[1]='I类';
$qixie_arr[2]='II类';
$qixie_arr[3]='III类';
$qixie_arr[4]='其他';

$level_arr=array();
$level_arr[1]='研发阶段';
$level_arr[2]='完成小试';
$level_arr[3]='完成中试';
$level_arr[4]='完成临床试验';
$level_arr[5]='可量产';
$level_arr[6]='已量产';

include template('index', $module);
?>
