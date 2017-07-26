<?php
/*
time:2015/10/27
who ：xiaolv
rel : 暂无
*/
require_once '../common.inc.php';

$wap = true;
$forward = 'index.php?moduleid='.$moduleid.'&itemid='.$itemid;
captcha($captcha,3,false,$forward,$wap);
$the_time = time();
$query = "INSERT INTO ".$DT_PRE."comment SET 
	item_mid = '$moduleid',item_id = '$itemid', item_title = '$title',
	item_username='$author', star = '$star',content='$content', qid=0, username='$username',hidden = 0,
	addtime = '$the_time',ip='$DT_IP',status =3,replytime =0,agree=0,against=0,quote=0
	";
$db->query($query);
$the_itemid = $db->insert_id();

$query = "SELECT sid,star".$star.",comment FROM ".$DT_PRE."comment_stat WHERE moduleid='$moduleid' AND itemid = '$itemid'";
$res = $db->get_one($query);
if ($res) {
	$query="UPDATE ".$DT_PRE."comment_stat SET comment = '".($res['comment']+1)."',star".$star."='".($res['star'.$star]+1)."' WHERE sid='".$res['sid']."'";
	$update_res = $db->query($query);
	if($update_res){
		$the_comment = true;
	}else{
		$the_comment = false;
	}
}else{
	$query = "INSERT INTO ".$DT_PRE."comment_stat SET moduleid = '$moduleid', itemid ='$itemid',comment = 1, star".$star."='".($res['star'.$star]+1)."'";
	$insert_res = $db->query($query);
	if($insert_res){
		$the_comment = true;
	}else{
		$the_comment = false;
	}
}
if($the_comment){
	message('评论成功',$forward,3,$wap);
}else{
	message('评论失败',$forward,3,$wap);
}
?>