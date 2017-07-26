<?php
require '../common.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?php
/*
火车头采集文章
文章所属栏目由火车头web发布模块编辑填栏目catid
*/

$checkPower = $_REQUEST["checkPower"];
	if($checkPower == "hekw07"){
		$title = $_REQUEST["title"];
		if(strlen($title) < 4){die("Unvalid result!");}
		global $DT_TIME,$DT_IP;
		$catid = $_REQUEST["catid"];
		$areaid = $_REQUEST["areaid"];
		$lever = $_REQUEST["level"];;
		$fee = $_REQUEST["fee"];
		$introduce = $_REQUEST["introduce"];
		//$introduce = trim($introduce);
		if(strlen($introduce) > 350){
			$introduce = substr($introduce,0,350);
		}
		$tag = $_REQUEST["tag"];
		//$keyword = $title.",".$catid;
		$copyfrom = $_REQUEST["copyfrom"];
		$username = $_REQUEST["username"];
		$editor = $_REQUEST["editor"];
		$content = $_REQUEST["content"];

		$check_title = $db->get_one("SELECT COUNT(*) AS num FROM tc_article_21 WHERE title = '$title'");
		if($check_title["num"] != 0){
			die("have this article!");
		}else{
			$result_info = $db->query("INSERT INTO tc_article_21 (itemid,catid,areaid,level,title,fee,introduce,copyfrom,username,addtime,editor,edittime,ip,status,linkurl,daodu) VALUES ('','$catid','0','$level','$title','0','$introduce','$copyfrom','$username','$DT_TIME','$editor','$DT_TIME','$DT_IP','3','','1')");
				$get_itemid = $db->query("SELECT itemid FROM tc_article_21 WHERE username = '$username' ORDER BY itemid DESC LIMIT 0,1");
				while($row = mysql_fetch_row($get_itemid)){
					$db->query("INSERT INTO tc_article_data_21 SET itemid = '$row[0]' , content = '$content'");
					$db->query("UPDATE tc_article_21 SET linkurl = 'show-htm-itemid-$row[0].html' WHERE itemid = '$row[0]'");
		}
		return true;
	}
	}else{
		print_r("你最好马上离开，并把电脑给烧了！5秒钟后自动报警！");
		return false;
	}
?>
</body>
</html>