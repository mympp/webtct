<?php
/**
* 信息评论接口，异步处理用户对信息的评论
*/
defined('IN_DESTOON') or exit('Access Denied');

if(!isset($moduleid)) exit('-1');
if(!isset($itemid)) exit('-1');
if(!isset($star)) exit('-1');
if(!in_array($star,[1,2,3])) exit('-1');

require DT_ROOT.'/include/tcdb.class.php';
$comment_stat = new tcdb('comment_stat');
$comment = $comment_stat->where(['moduleid'=>$moduleid,'itemid'=>$itemid])->one();
if(empty($comment)){	//此前没有该信息评论
	$data['moduleid'] = $moduleid;
	$data['itemid'] = $itemid;
	$data['comment'] = 0;
	$data['star1'] = $star == '1' ? 1 : 0;
	$data['star2'] = $star == '2' ? 1 : 0;
	$data['star3'] = $star == '3' ? 1 : 0;
	$comment_stat->add($data);
	exit('1');
}else{
	$data = [];
	switch($star){
		case '1':
			$data['star1'] = (int)$comment['star1'] + 1;
		break;
		case '2':
			$data['star2'] = (int)$comment['star2'] + 1;
		break;
		case '3':
			$data['star3'] = (int)$comment['star3'] + 1;
		break;
	}
	$comment_stat->edit($data,['sid'=>$comment['sid']]);
	exit('1');
}
?>