<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if(!check_group($_groupid, $MOD['group_index'])) include load('403.inc');

//友情链接
$link_db = new tcdb('link');
$links = $link_db->field('title,linkurl')->where(['status'=>3,'link_moduleid'=>6])->order('listorder asc')->limit(0,30)->select();


$seo_file = 'index';
include DT_ROOT.'/include/seo.inc.php';
include template($MOD['template_index'] ? $MOD['template_index'] : 'index', $module);

?>