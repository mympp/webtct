<?php
use models\helpers\data\tcdb;
use models\helpers\widget\redirect\pc_to_wap;

defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';

$wapurl = pc_to_wap::forword('gongxiang');

if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');
$maincat = get_maincat(0, $moduleid, 1);
$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
$template = $MOD['template_index'] ? $MOD['template_index'] : 'index';
$destoon_task = "moduleid=$moduleid&html=index";

//友情链接
$link_db = new tcdb('link');
$links = $link_db->field('title,linkurl')->where(['status'=>3,'link_moduleid'=>15])->order('listorder asc')->limit(0,30)->select();

$down_db = new tcdb('down_15');
$count = $down_db->where(['status'=>3])->count('c');
include template($template, $module);
?>