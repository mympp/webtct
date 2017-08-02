<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array("添加服务需求", "?moduleid=$moduleid&action=add"),
	array("批量添加服务需求", "?moduleid=$moduleid&file=batch_add_job"),
	array("服务需求列表", "?moduleid=$moduleid"),
	array("审核服务需求", "?moduleid=$moduleid&action=check"),
	array("报名参与的记录", "?moduleid=$moduleid&file=apply"),
	array("添加技术供应", "?moduleid=$moduleid&file=resume&action=add"),
	array("技术供应列表", "?moduleid=$moduleid&file=resume"),
	array("审核技术供应", "?moduleid=$moduleid&file=resume&action=check"),
	array("分类管理", "?file=category&mid=$moduleid"),
	array("更新数据", "?moduleid=$moduleid&file=html"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
	array("服务需求评语添加","?moduleid=$moduleid&file=person_do_comtem&action=add"),
	array("服务需求评语模板","?moduleid=$moduleid&file=person_do_comtem"),
	array("人气助手", "?moduleid=$moduleid&file=person_do_member"),
);
?>