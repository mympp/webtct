<?php
defined('DT_ADMIN') or exit('Access Denied');
$db->query("DROP TABLE IF EXISTS `".$DT_PRE.$module."_job`");
$db->query("DROP TABLE IF EXISTS `".$DT_PRE.$module."_job_data`");
$db->query("DROP TABLE IF EXISTS `".$DT_PRE.$module."_job_apply`");
$db->query("DROP TABLE IF EXISTS `".$DT_PRE.$module."_job_talent`");
$db->query("DROP TABLE IF EXISTS `".$DT_PRE."hr_resume`");
$db->query("DROP TABLE IF EXISTS `".$DT_PRE."hr_resume_data`");
?>