<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
$sql = "SELECT * FROM ".$DT_PRE."keyword WHERE moduleid=16 and status = 3 and letter <>''";
$result = $db->query($sql);
while ($r = $db->fetch_array($result)) {
	if($r['letter']==$kw){
		$kw = $r['keyword'];
		$keyword = $kw;
		break;
	}
}
require DT_ROOT.'/module/'.$module.'/search_fuwu.inc.php';
?>