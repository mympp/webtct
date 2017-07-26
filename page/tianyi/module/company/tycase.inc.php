<?php
defined('IN_DESTOON') or exit('Access Denied');
$table_tycase = $DT_PRE.'tycase';
$condition = "username='$username' AND status=3";
include template('tycase', $template);
?>