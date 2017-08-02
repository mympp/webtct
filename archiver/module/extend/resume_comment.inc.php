<?php 
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
$itemid or exit;
$select_star = array(array('服务态度','响应时间','技术能力'),array('很差','差','一般','好','非常好'),array('很慢','慢','一般','快','非常快'));
$table = $DT_PRE."resume_comment";
switch($action){
	case 'vote':
		//!check_group($_groupid, $MOD['comment_vote_group']) ||   取消此判断所有人都可投票
		if(!$MOD['comment_vote']) exit('-2');
		$rc_id = isset($rc_id) ? intval($rc_id) : 0;
		$rc_id or exit('0');
		$op = $op ? 1 : 0;
		$f = $op ? 'agree' : 'disagree';
		if(get_cookie('comment_vote_'.$rc_id)) exit('-1');
		$db->query("UPDATE $table SET `{$f}`=`{$f}`+1 WHERE rc_id=$rc_id");
		set_cookie('comment_vote_'.$rc_id, 1, $DT_TIME + 365*86400);
		exit('1');
		break;
	
	case 'delete':			
			$sql = "DELETE FROM $table WHERE item_id = $itemid AND rc_id = $rc_id";
			$db->query($sql);
			$twap = '';
			if ($wap) {
				$twap = '&wap=1';
			}
			$forward = $MOD['linkurl'].'resume_comment.php?itemid='.$itemid.$twap.'&page='.$page.'&rand='.mt_rand(10, 99);			
			dalert('', '', 'parent.window.location="'.$forward.'";');
		break;

	default:
		if(check_group($_groupid, $MOD['comment_group'])) {
			$user_status = 3;
		} else {
			if($_userid) {
				$user_status = 1;
			} else {
				$user_status = 2;
			}
		}	
		
		if($submit){
			$comment_content = dhtmlspecialchars(trim($comment_content));
			$comment_content = preg_replace("/&([a-z]{1,});/", '', $comment_content);
			$star_attitude = intval($star_attitude);
			$star_time = intval($star_time);
			$star_quality = intval($star_quality);
			$db->query("INSERT INTO $table (rc_id,item_id,from_username,star_attitude,star_time,star_quality,commented_time,content,agree,disagree,ip) VALUES ('','$itemid','$username','$star_attitude','$star_time','$star_quality','$DT_TIME','$comment_content','0','0','$DT_IP')");
			dalert('', '', 'parent.window.location=parent.window.location;');
		}else{
			$pages = '';
			$pagesize = $offset = 0;	
			if($MOD['comment_pagesize']) {
				if ($wap) {
					$pagesize = 5;
				}else{
					$pagesize = $MOD['comment_pagesize'];
				}
				$offset = ($page-1)*$pagesize;
			}
			$p = $db->get_one("SELECT COUNT(*) AS num,sum(star_attitude) AS star_attitude,sum(star_time) AS star_time,sum(star_quality) AS star_quality FROM $table WHERE item_id = '$itemid'");
			$items = $p['num'];
			$star_attitude=number_format($p['star_attitude']/$items,2);
			switch(intval($star_attitude)){
				case '1':$attitude_level = $select_star[1][0];break;
				case '2':$attitude_level = $select_star[1][1];break;
				case '3':$attitude_level = $select_star[1][2];break;
				case '4':$attitude_level = $select_star[1][3];break;
				case '5':$attitude_level = $select_star[1][4];break;
				default:$attitude_level = " ";
			}
			$star_time=number_format($p['star_time']/$items,2);
			switch(intval($star_time)){
				case '1':$time_level = $select_star[2][0];break;
				case '2':$time_level = $select_star[2][1];break;
				case '3':$time_level = $select_star[2][2];break;
				case '4':$time_level = $select_star[2][3];break;
				case '5':$time_level = $select_star[2][4];break;
				default:$time_level = " ";
			}
			$star_quality=number_format($p['star_quality']/$items,2);
			switch(intval($star_quality)){
				case '1':$quality_level = $select_star[1][0];break;
				case '2':$quality_level = $select_star[1][1];break;
				case '3':$quality_level = $select_star[1][2];break;
				case '4':$quality_level = $select_star[1][3];break;
				case '5':$quality_level = $select_star[1][4];break;
				default:$quality_level = " ";
			}
			$offset = ($page-1)*$pagesize;
			$pages = pages($items,$page,$pagesize);
			$floor = $page == 1 ? 0 : ($page-1)*$pagesize;
			
			$rc_lists = array();
			$rc_sql = "SELECT * FROM $table WHERE item_id = '$itemid' ORDER BY item_id DESC LIMIT $offset,$pagesize";//查询被点评工程师的点评
			$result = $db->query($rc_sql);
			while($r = $db->fetch_array($result)) {
				$r['commented_time'] = timetodate($r['commented_time'], 6);
				$r['floor'] = ++$floor;
				$rc_lists[] = $r;
			}		
			if ($wap) {
				include template('wap_resume_comment', $module);
			}else {
				include template('resume_comment', $module);
			}
			
		}
}
?>