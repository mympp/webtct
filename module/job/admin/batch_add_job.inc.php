<?php
 
defined('IN_DESTOON') or exit('Access Denied');
require MD_ROOT.'/batch_add_job.class.php';
$do = new batch_add_job($moduleid);

include tpl("batch_add_job",$module);
if($submit && $action == "add"){
	$do->add($leibei,$diziid,$title,$department,$minsalary,$maxsalary,$fenlei,$address,$pinpai,$xinghao,$content,$tobe,$post);
	dmsg("添加成功",$forward);
}
?>