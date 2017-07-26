<?php
require '../common.inc.php';
$fname="";
$tz=intval($_REQUEST["tz"]);
$fname=addslashes($_REQUEST["fname"]);
if ($tz==''){
include template('tree','brand');
}
else
{
require '../include/post.func.php';
include template('tree2','brand'); 
}
$id1=intval($_REQUEST["id1"]);
$id2=intval($_REQUEST["id2"]);
$id3=intval($_REQUEST["id3"]);
$id4=intval($_REQUEST["id4"]);
$id5=intval($_REQUEST["id5"]);
$itemid=intval($_REQUEST["itemid"]);
?> 
