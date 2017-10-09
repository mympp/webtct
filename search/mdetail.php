<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
$module='search';

if($infotype == '2'){
	$page_template = 'mdetail-company';
}elseif($infotype == '1'){
	$page_template = 'mdetail-product';
}else{
	$page_template = 'mdetail';
}
require DT_ROOT.'/module/'.$module.'/detail.inc.php';
?>