<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
$group = $_POST["group"];
echo "以<b style=\"color:red\">".$group."</b>为一组的";
$email = $_POST["email"];
$emailarray = array();
$emailarray = explode(";",$email);
$emailgroup = array_chunk($emailarray,$group);
foreach($emailgroup as $k=>$v){
	echo "<br/><hr/><div id=\"".$k."\">第".$k."组：<br/><form method=\"post\" action=\"chunk.php\" target=\"_blank\"><textarea onclick=\"oCopy(this)\" name=\"email\" rows=\"10\" cols=\"120\">";
		foreach($v as $i=>$j){
			echo $j.";";
		}
		echo "</textarea><br/>以每<input type=\"text\" size=\"5\" name=\"group\" value=\"\" \>为一组<br/><input type=\"submit\" name=\"submit\" value=\"确定\" /></form><br /></div>";
}
?>
</body>
</html>
<script language="javascript"> 
function oCopy(obj){ 
	obj.select(); 
	js=obj.createTextRange(); 
	js.execCommand("Copy")
	alert("复制成功!"); 
} 
</script>