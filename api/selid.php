<?php
require '../common.inc.php';


$ls = array();
$getid = $db->query("select itemid from tc_brand_13 where ip='127.0.0.1' and status = 2");

while($r = $db->fetch_array($getid)){
	$ls[] = $r[itemid];
}
echo count($ls);echo "<hr/>";
foreach($ls as $l=>$s){
	echo "delete from tc_brand_13 where itemid = '$s';";
}

?>



