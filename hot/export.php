<?php 
require_once '../common.inc.php';
error_reporting(E_ALL);
$sql ="SELECT * FROM {$DT_PRE}keyword WHERE status =3 AND moduleid=16 ORDER BY convert(letter using gbk) ASC ";
$result = $db->query($sql);
$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$str = '';
while ($r = $db->fetch_array($result)) {
	$keywords[] = $r;
	if($r['letter']){
		$_letter = strtolower(substr($r['letter'], 0, 1));
		if(in_array($_letter, $letters)){
			$letter_keyword[$_letter][] = $r;
			$str .= $r['letter'].'-'.$r['itemid'].'
';
		}else{
			$letter_keyword['num'][] = $r;
		}
	}	
}
$file = fopen('url.txt', 'w');
file_put_contents('url.txt', $str);
fclose($file);
?>