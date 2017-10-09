<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
$module='search';
$template = 'msearch';
require DT_ROOT.'/module/'.$module.'/search.inc.php';

?>