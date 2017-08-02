<?php
/*
who:chentao
when:2015-10-26
where:新增
what:联系我们页面
relation:/template/tc/quote/contactus.html,/tech/contactus.php
*/
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
include template('contactus', $module);
?>