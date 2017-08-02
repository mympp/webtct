<?php
require '../common.inc.php';
$db->query("UPDATE {$DT_PRE}setting SET item_value=item_value+1 WHERE item_key='page_trade'");
$t = $db->get_one("SELECT item_value FROM {$DT_PRE}setting WHERE item_key='page_trade'",'',0);
$count_num=$t['item_value'];
echo  "document.write('".number_format($count_num,0,'.',',')."');";
 ?>
