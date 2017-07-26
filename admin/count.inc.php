<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
array('信息统计', '?file='.$file),
array('统计报表', '?file='.$file.'&action=stats'),
);
$temporary_table = "(select * from (SELECT * FROM `tc_weixin_chat` where event = 0 and type <> 'push' and kefu_status <> 1 order by addtime desc) as temporary group by openid order by addtime desc)";

switch($action) {
	case 'js':
		$db->halt = 0;
		$today = strtotime(timetodate($DT_TIME, 3).' 00:00:00');
		//

		$num = $db->count($DT_PRE.'finance_charge', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("charge").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'finance_cash', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("cash").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'mall_order', "status=5");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("trade").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'group_order', "status=4");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("group").innerHTML="'.$num.'";}catch(e){}';




		$num = $db->count($DT_PRE.'ask', "status=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("ask").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'guestbook', "edittime=0");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("guestbook").innerHTML="'.$num.'";}catch(e){}';
		
		$temporary_table = "(select * from (SELECT * FROM `tc_weixin_chat` where event = 0 and type <> 'push' and kefu_status <> 1 order by addtime desc) as temporary group by openid order by addtime desc)";
		$items = $db->get_one("select count(*) as num from $temporary_table as t where t.type <> 'reply'");
		$num = $items['num'];
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("weixin").innerHTML="'.$num.'";}catch(e){}';
		
		$num = $db->count($DT_PRE.'company_edit','status=2');
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("company_edit").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'comment', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("comment").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'link', "status=2 AND username=''");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("link").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'news', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("news").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'honor', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("honor").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'link', "status=2 AND username<>''");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("comlink").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'keyword', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("keyword").innerHTML="'.$num.'";}catch(e){}';

		foreach(array('company', 'truename', 'mobile', 'email') as $v) {//V6.0 新增
			$num = $db->count($DT_PRE.'validate', "type='$v' AND status=2");//待审核认证
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{document.getElementById("v'.$v.'").innerHTML="'.$num.'";}catch(e){}';
		}

		$num = $db->count($DT_PRE.'member_check', "1");//待审核资料修改
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("edit_check").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'ad', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("ad").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'spread', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("spread").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'club_group', "status=2");//商圈 V6.0 新增
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("club_group").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'club_reply', "status=2");//商圈回复 V6.0 新增
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("club_reply").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'club_fans', "status=2");//商圈粉丝 V6.0 新增
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("club_fans").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'know_answer', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("answer").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'upgrade', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("member_upgrade").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'alert', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("alert").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'member', "groupid=4");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("member_check").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'company', "groupid>5 and catids='' and closeshop=1");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("companyz").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'page', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("pages").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'company', "groupid>5 and thumb='' and (catid='' or catids='')");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("companyl").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'taoxinxi', "level=0 or level=1");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("taoxinxi2").innerHTML="'.$num.'";}catch(e){}';

		$num = $db->count($DT_PRE.'validate', "status=2");
		$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
		echo 'try{document.getElementById("validate").innerHTML="'.$num.'";}catch(e){}';

		if($_REQUEST['type']){
			
			//待审核产品报价
			$num = $db->count($DT_PRE.'quote_price', "status=2");
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{document.getElementById("quote_price").innerHTML="'.$num.'";}catch(e){}';
			
			//会员
			$num = $db->count($DT_PRE.'member');
			echo 'try{document.getElementById("member").innerHTML="'.$num.'";}catch(e){}';

			foreach($MODULE as $m) {
				if($m['moduleid'] < 5 || $m['islink']) continue;
				$table = get_table($m['moduleid']);
				//ALL
				$num = $db->count($table, '1');
				echo 'try{Dd("m_'.$m['moduleid'].'").innerHTML="'.$num.'";}catch(e){}';
				//PUB
				$num = $db->count($table, "status=3");
				echo 'try{Dd("m_'.$m['moduleid'].'_1").innerHTML="'.$num.'";}catch(e){}';
				//CHECK
				$num = $db->count($table, "status=2");
				$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
				echo 'try{Dd("m_'.$m['moduleid'].'_2").innerHTML="'.$num.'";}catch(e){}';
				//NEW
				$num = $db->count($table, "addtime>$today", 30);
				echo 'try{Dd("m_'.$m['moduleid'].'_3").innerHTML="'.$num.'";}catch(e){}';

				if($m['moduleid'] == 9) {
					$table = $DT_PRE.'resume';
					//ALL
					$num = $db->count($table, '1');
					echo 'try{Dd("m_resume").innerHTML="'.$num.'";}catch(e){}';
					//PUB
					$num = $db->count($table, "status=3");
					echo 'try{Dd("m_resume_1").innerHTML="'.$num.'";}catch(e){}';
					//CHECK
					$num = $db->count($table, "status=2");
					$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
					echo 'try{Dd("m_resume_2").innerHTML="'.$num.'";}catch(e){}';
					//NEW
					$num = $db->count($table, "addtime>$today");
					echo 'try{Dd("m_resume_3").innerHTML="'.$num.'";}catch(e){}';
				}
			}

			$num = $db->count($DT_PRE.'company', "groupid>4");
			$num = $num ? ''.$num.'' : 0;
			echo 'try{document.getElementById("companyc").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'company', "thumb<>''");
			$num = $num ? ''.$num.'' : 0;
			echo 'try{document.getElementById("companyy").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'company', "closeshop=1 and pnum=0");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("companyg").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'taoxinxi', "level>0");
			$num = $num ? $num : 0;
			echo 'try{document.getElementById("taoxinxi").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'company', "vip>0");
			$num = $num ? ''.$num.'' : 0;
			echo 'try{document.getElementById("member_vip").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'member', "regtime>$today");
			echo 'try{document.getElementById("member_new").innerHTML="'.$num.'";}catch(e){}';

		}//if 结束

		if(!$_REQUEST['type']){
			$userlist=getsqldata("username","{$db->pre}member","groupid=1",10);
			foreach($userlist as $k => $v) {
				$count_pre = '<span>';
				$count_next = '</span>';
				if($v['username'] == $_username){
					$count_pre= '<strong class=\"f_red\">';		//当统计用户为当前用户时才飘红
					$count_next = '</strong>';
				} 
				
				$num = $db->count($DT_PRE.'message', "touser='".$v['username']."'");
				$num = $num ? '<span>'.$num.'</span>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_message").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'message', "touser='".$v['username']."' and isread=0");
				$num = $num ? $count_pre.$num.$count_next : 0;
				echo 'try{document.getElementById("to_'.$v['username'].'_message_noread").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'message', "fromuser='".$v['username']."' and isread=0");
				$num = $num ? $count_pre.$num.$count_next : 0;
				echo 'try{document.getElementById("from_'.$v['username'].'_message_noread").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'mall_order', "seller='".$v['username']."' and status=0");
				$num = $num ? $count_pre.$num.$count_next : 0;
				echo 'try{document.getElementById("'.$v['username'].'_order_seller").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'mall_order', "buyer='".$v['username']."' and status=1");
				$num = $num ? $count_pre.$num.$count_next : 0;
				echo 'try{document.getElementById("'.$v['username'].'_order_buyer").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'job', "username='".$v['username']."' and status=3");
				$num = $num ? '<span>'.$num.'</span>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_job").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'job', "username='".$v['username']."' and status=3 and apply=0 and step<4");
				$num = $num ? '<span >'.$num.'</span>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_job_apply").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'resume', "username='".$v['username']."' and status=3 and talent=0");
				$num = $num ? '<span>'.$num.'</span>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_job_talent").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'job', "username='".$v['username']."' and status=3 and step<4 and apply>0");
				$num = $num ? '<span>'.$num.'</span>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_job_step").innerHTML="'.$num.'";}catch(e){}';

				$num = $db->count($DT_PRE.'job_apply', "admin=0 and job_username='".$v['username']."'");
				$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
				echo 'try{document.getElementById("'.$v['username'].'_job_apply_noadmin").innerHTML="'.$num.'";}catch(e){}';
			}//foreach 结束

			$num = $db->count($DT_PRE.'message', "itemid>0");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_message").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'message', " isread=0");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("to_site_message_noread").innerHTML="'.$num.'";}catch(e){}';


			//逾期确认订单
			$wait_hours = $MOD['order_wait_check'];
			$wait_time = (int)$wait_hours * 3600;
			$nowtime = time();
			$num = $db->count($DT_PRE.'mall_order', "status=0 and ($nowtime - addtime) > $wait_time AND kefu_status = 0");
			$num = $num ? '<strong class=\"f_red\">'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_order_seller").innerHTML="'.$num.'";}catch(e){}';

			//逾期完成订单
			$wait_hours = $MOD['order_wait_finish'];
			$wait_time = (int)$wait_hours * 3600;
			$num = $db->count($DT_PRE.'mall_order', "status not in (0,4,8,9) AND ($nowtime - updatetime) > $wait_time AND kefu_status = 0");
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{document.getElementById("site_order_buyer").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'job', " status=3");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_job").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'job', " status=3 and apply=0 and step<4");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_job_apply").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'resume', "status=3 and talent=0");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_job_talent").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'job_apply', "admin=0");
			$num = $num ? '<span>'.$num.'</span>' : 0;
			echo 'try{document.getElementById("site_job_apply_noadmin").innerHTML="'.$num.'";}catch(e){}';

			$num = $db->count($DT_PRE.'job', "status=3 and step<4 and apply>0");
			$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
			echo 'try{document.getElementById("site_job_step").innerHTML="'.$num.'";}catch(e){}';

			foreach($MODULE as $m) {
				if($m['moduleid'] < 5 || $m['islink']) continue;
				$table = get_table($m['moduleid']);
				//CHECK
				$num = $db->count($table, "status=2");
				$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
				echo 'try{Dd("m_'.$m['moduleid'].'_2").innerHTML="'.$num.'";}catch(e){}';
				if($m['moduleid'] == 9) {
					$table = $DT_PRE.'resume';
					$num = $db->count($table, "status=2");
					$num = $num ? '<strong class=\"f_red\">'.$num.'</strong>' : 0;
					echo 'try{Dd("m_resume_2").innerHTML="'.$num.'";}catch(e){}';
				}
			}//foreach 结束
		}//if结束

	break;
	case 'stats'://V6.0 新增
		$year = isset($year) ? intval($year) : date('Y', $DT_TIME);
		$year or $year = date('Y', $DT_TIME);
		$month = isset($month) ? intval($month) : 0;
		if($mid == 1 || $mid == 3) $mid = 0;
		if($mid == 4) $mid = 2;
		include tpl('count_stats');
	break;
	case 'date':	//根据日期统计
		$fromtime = isset($fromtime) ? strtotime($fromtime) : strtotime(date('Y-m-d',time()));
		$totime = isset($totime) ? strtotime($totime) : time();
		include tpl('count_date');
	break;
	default:
		$year = isset($year) ? intval($year) : date('Y', $DT_TIME);
		$year or $year = date('Y', $DT_TIME);
		$month = isset($month) ? intval($month) : 0;
		if($mid == 1 || $mid == 3) $mid = 0;
		if($mid == 4) $mid = 2;
		include tpl('count');
	break;
}
?>