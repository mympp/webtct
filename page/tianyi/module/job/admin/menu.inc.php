<?php
defined('DT_ADMIN') or exit('Access Denied');
$menu = array(
	array("添加工程", "?moduleid=$moduleid&action=add"),
	array("工程列表", "?moduleid=$moduleid"),
	array("审核工程", "?moduleid=$moduleid&action=check"),
	array("添加应标", "?moduleid=$moduleid&file=resume&action=add"),
	array("应标列表", "?moduleid=$moduleid&file=resume"),
	array("审核应标", "?moduleid=$moduleid&file=resume&action=check"),
	array("分类管理", "?file=category&mid=$moduleid"),
	array("更新数据", "?moduleid=$moduleid&file=html"),
	array("模块设置", "?moduleid=$moduleid&file=setting"),
);
?>