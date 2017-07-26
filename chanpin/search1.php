<?php
define('DT_REWRITE', true);
require 'config.inc.php';
require '../common.inc.php';
$key_words = tag("moduleid=1&table=keyword&condition=moduleid=16 and length(word)>4   and length(word)<10 and status=3 &pagesize=20&order=month_search desc&key=month_search&template=null&debug=0", -2);
foreach ($key_words as $key => $key_word) {
	if($key_word['letter']==$kw){
		$kw = $key_word['keyword'];
		break;
	}
}
require DT_ROOT.'/module/'.$module.'/search.inc.php';
?>