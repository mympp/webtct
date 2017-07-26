<?
include "../api/phpqrcode/phpqrcode.php";
$dz=$_GET["dz"];
if(@$_GET["us"]){
	$us=$_GET["us"];
	$value=$dz."&".$us;
}else{
	$value=$dz;
}
$size= isset($_GET["size"]) ? $_GET['size'] : 6;
$errorCorrectionLevel = 'L';
$matrixPointSize = 2;
if($size)$matrixPointSize =$size;
QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
exit;
?>