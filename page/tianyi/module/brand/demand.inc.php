<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($MOD['index_html']) {
	$html_file = DT_ROOT.'/'.$MOD['moduledir'].'/'.$DT['index'].'.'.$DT['file_ext'];
	if(!is_file($html_file)) tohtml('demand', $module);
	if(is_file($html_file)) exit(include($html_file));
}
if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'demand';
include DT_ROOT.'/include/seo.inc.php';
$destoon_task = "moduleid=$moduleid&html=index";
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].mobileurl($moduleid, 0, 0, $page);
$demand=$_GET['demand'];
switch($demand){
	case 'design':break;
	case'costs':;break;
	case'construction':;break;
	case'maintain':;break;
	default: $demand='design';
}
$demand_arr=array(
		array('title'=>'设计需求','value'=>'design'),
		array('title'=>'造价需求','value'=>'costs'),
		array('title'=>'施工需求','value'=>'construction'),
		array('title'=>'维保需求','value'=>'maintain')
);
include template($MOD['template_index'] ? $MOD['template_index'] : 'demand', $module);
?>