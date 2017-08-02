<?php 
/*
* 何楷伟
* 2013-07-18
* 
*/
defined('IN_DESTOON') or exit('Access Denied');
class person_do_job {
	var $moduleid;
	var $itemid;
	var $db;
	var $table;
	var $errmsg = errmsg;

    function person_do_job($moduleid) {
		global $db, $table, $table_data, $MOD;
		$this->moduleid = $moduleid;
		$this->table = $table;
		$this->db = &$db;
    }

	function pass($post){
		//判断post传送是否为数组
		if(!is_array($post)) return false;
		return true;
	}

	function check_empty($post){
		//判断post转送是否为空
		if(empty($post)) return false;
		else return true;
	}

	function member_selected($userid){
		//将userid传送过来的字符串explode切割为数组，再通过foreach循环插入
		foreach($userid as $k=>$v){
			$fen = explode(",",$v);
			$this->db->query("INSERT INTO tc_person_do_select_members (userid,username) VALUES ('$fen[0]','$fen[1]')");
		}
		return true;
	}

	function delete_seled_member(){
		//清空已选名义会员
		$this->db->query("DELETE FROM tc_person_do_select_members");
	}

	function members(){
		//获取名义会员名单
		$members = array();
		$members_result = $this->db->query("SELECT * FROM tc_person_do_select_members");
		while($r = $this->db->fetch_array($members_result)){
			$members[] = $r;
		}
		foreach($members as $k=>$v){
			$r = $this->db->get_one("SELECT COUNT(*) AS num,itemid FROM tc_resume WHERE username='$v[username]'");//查询tc_resume表,num在person_do_comment.tpl.php判断是否username存在resume,resumeid在提交报名时function apply()插入
			$members[$k]['num'] = $r['num'];
			$members[$k]['resumeid'] = $r['itemid'];
		}
		return $members;
	}

	function job_comments(){
		//获取服务需求评语模板
		$comments = array();
		$comments_result = $this->db->query("SELECT * FROM tc_person_do_comment_templates WHERE tem_class=1");
		while($r = $this->db->fetch_array($comments_result)){
			$comments[] = $r;
		}
		return $comments;
	}

	function product_comments(){
		//获取产品中心评语模板
		$comments = array();
		$comments_result = $this->db->query("SELECT * FROM tc_person_do_comment_templates WHERE tem_class=2");
		while($r = $this->db->fetch_array($comments_result)){
			$comments[] = $r;
		}
		return $comments;
	}

	function apply($txt){
		//将txt传送过来的字符串通过explode切割为数组foreach插入
		//报名函数
		global $DT_TIME;
		foreach($txt as $k=>$v){
			$fen = explode(",",$v);
			$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_job_apply WHERE jobid='$fen[0]' AND apply_username='$fen[4]'");
			if($r['num'] == 0){
				$this->db->query("UPDATE tc_job SET apply=apply+1 WHERE title='$fen[1]'");
				$this->db->query("INSERT INTO tc_job_apply (applyid,jobid,resumeid,job_username,apply_username,applytime) VALUES ('','$fen[0]','$fen[2]','$fen[3]','$fen[4]','$DT_TIME')");
			}else{
				msg($fen['4']."等人已经报名");
			}
		}
		return true;
	}

	function commented($post){
		//点评函数
		global $DT_TIME,$DT_IP;
		if($post['item_mid'] == 9){
			$linkurl = DT_PATH."job/".$post['item_linkurl'];
		}else if($post['item_mid'] == 16){
			$linkurl = DT_PATH."mall/".$post['item_linkurl'];
		}else{
			$linkurl = $post['item_linkurl'];
		}

		$seled_members = substr($post["seled_members"],0,strlen($post["seled_members"])-1);//去除传送$post["seled_members"]字符串的最后一个字符“|”，作用：explode切割后不会有空的数组单元
		$seled_comments = substr($post["seled_comments"],0,strlen($post["seled_comments"])-1);

		$fen_members = explode("|",$seled_members);//将去除最后一个字符“|”后的字符串explode切割为数组
		$fen_comments = explode("|",$seled_comments);

		$comment_stat_result = $this->db->get_one("SELECT COUNT(itemid) AS num FROM tc_comment_stat WHERE itemid='$post[item_id]'"); //评论统计表查询itemid是否存在

		if(count($fen_members) == 1 && count($fen_comments) == 1){
			//一个会员对一条评语：直接插入
			$this->db->query("INSERT INTO tc_comment (itemid,item_mid,item_id,item_title,item_linkurl,item_username,star,content,qid,quotation,username,hidden,addtime,reply,editor,replyer,replytime,agree,against,quote,ip,status) VALUES ('','$post[item_mid]','$post[item_id]','$post[item_title]','$linkurl','$post[item_username]','3','$seled_comments','0','','$seled_members','0','$DT_TIME','','','','0','0','0','0','$DT_IP','3')");
			if($comment_stat_result["num"] == 1){//判断评论统计是否存在统计，是，在原统计上加1；否，创建新统计
				$this->db->query("UPDATE tc_comment_stat SET comment=comment+1,star3=star3+1 WHERE itemid = '$post[item_id]'");//在原有统计上加1
			}else{
				$this->db->query("INSERT INTO tc_comment_stat (sid,moduleid,itemid,comment,star1,star2,star3) VALUES ('','$post[item_mid]','$post[item_id]','1','0','0','1')");
			}
		}
		if(count($fen_members) == 1 && count($fen_comments) > 1){
			//一个会员对多条评语：随机选取选定评语的一个单元插入
			$rand_key = array_rand($fen_comments,1);
			$rand_comment = $fen_comments[$rand_key];
			$this->db->query("INSERT INTO tc_comment (itemid,item_mid,item_id,item_title,item_linkurl,item_username,star,content,qid,quotation,username,hidden,addtime,reply,editor,replyer,replytime,agree,against,quote,ip,status) VALUES ('','$post[item_mid]','$post[item_id]','$post[item_title]','$linkurl','$post[item_username]','3','$rand_comment','0','','$seled_members','0','$DT_TIME','','','','0','0','0','0','$DT_IP','3')");
			if($comment_stat_result["num"] == 1){//判断评论统计是否存在统计，是，在原统计上加1；否，创建新统计
				$this->db->query("UPDATE tc_comment_stat SET comment=comment+1,star3=star3+1 WHERE itemid = '$post[item_id]'");//在原有统计上加1
			}else{
				$this->db->query("INSERT INTO tc_comment_stat (sid,moduleid,itemid,comment,star1,star2,star3) VALUES ('','$post[item_mid]','$post[item_id]','1','0','0','1')");
			}
		}
		if(count($fen_members) > 1 && count($fen_comments) == 1){
			//多个会员对一条评语：每个会员用此评语foreach循环插入
			if($comment_stat_result["num"] == 0){//判断评论统计是否存在统计，否，创建新统计
				$this->db->query("INSERT INTO tc_comment_stat (sid,moduleid,itemid,comment,star1,star2,star3) VALUES ('','$post[item_mid]','$post[item_id]','0','0','0','0')");
			}
			foreach($fen_members as $k=>$v){
				$DT_TIME_add = $DT_TIME + (rand(2,10)*24*60*60)+rand(3000,7000);
				$addtime = $k == 0 ? $DT_TIME : $DT_TIME_add;
				$this->db->query("INSERT INTO tc_comment (itemid,item_mid,item_id,item_title,item_linkurl,item_username,star,content,qid,quotation,username,hidden,addtime,reply,editor,replyer,replytime,agree,against,quote,ip,status) VALUES ('','$post[item_mid]','$post[item_id]','$post[item_title]','$linkurl','$post[item_username]','3','$seled_comments','0','','$v','0','$addtime','','','','0','0','0','0','$DT_IP','3')");
				$this->db->query("UPDATE tc_comment_stat SET comment=comment+1,star3=star3+1 WHERE itemid = '$post[item_id]'");//在原有统计上循环加1
			}
		}
		if(count($fen_members) > 1 && count($fen_comments) > 1){
			//多个会员对多条评语：当会员数与评语数相同时，或者会员数小于评语数时，foreach循环$fen_members插入相同KEY的评语；当会员数大于评语数时，返回出提示框
			if($comment_stat_result["num"] == 0){//判断评论统计是否存在统计，否，创建新统计
				$this->db->query("INSERT INTO tc_comment_stat (sid,moduleid,itemid,comment,star1,star2,star3) VALUES ('','$post[item_mid]','$post[item_id]','0','0','0','0')");
			}
			if(count($fen_members) == count($fen_comments) || count($fen_members) < count($fen_comments)){
				foreach($fen_members as $k=>$v){
					$DT_TIME_add = $DT_TIME + (rand(2,10)*24*60*60)+rand(3000,7000);
					$addtime = $k == 0 ? $DT_TIME : $DT_TIME_add;
					$this->db->query("INSERT INTO tc_comment (itemid,item_mid,item_id,item_title,item_linkurl,item_username,star,content,qid,quotation,username,hidden,addtime,reply,editor,replyer,replytime,agree,against,quote,ip,status) VALUES ('','$post[item_mid]','$post[item_id]','$post[item_title]','$linkurl','$post[item_username]','3','$fen_comments[$k]','0','','$v','0','$addtime','','','','0','0','0','0','$DT_IP','3')");
					$this->db->query("UPDATE tc_comment_stat SET comment=comment+1,star3=star3+1 WHERE itemid = '$post[item_id]'");//在原有统计上循环加1
				}
			}
			if(count($fen_members) > count($fen_comments)){
				msg("请选择点评会员人数与评语数相同！");
			}
		}
		if($post['item_mid'] == 9){
			$this->db->query("UPDATE tc_job SET new_comment_time = $DT_TIME WHERE itemid = '$post[item_id]'");//在tc_job表添加了new_comment_time字段，来存储最新点评的时间
		}
		if($post['item_mid'] == 16){
			$this->db->query("UPDATE tc_mall SET new_comment_time = $DT_TIME WHERE itemid = '$post[item_id]'");
		}
		
	}

/*产品评价*/
	function product_comments_pingjia(){
		//获取产品中心评价模板
		$comments = array();
		$comments_result = $this->db->query("SELECT * FROM tc_person_do_comment_templates WHERE tem_class=4");
		while($r = $this->db->fetch_array($comments_result)){
			$comments[] = $r;
		}
		return $comments;
	}

	function sel_pingjia($post){
		$sel_pingjia = array();
		$result = $this->db->query("SELECT * FROM tc_mall_comment WHERE mallid = '$post[item_id]'");
		while($r = $this->db->fetch_array($result)){
			$sel_pingjia[] = $r;
		}
		return $sel_pingjia;
	}

	function delete_pingjia($itemid,$mallid){
		$check = $this->db->get_one("SELECT tc_member.username AS username FROM tc_member WHERE tc_member.username = (SELECT buyer FROM tc_mall_comment WHERE itemid = '$itemid')");
		if($check["username"] != NULL){
			msg('您删除的评价不是经升人气评价的，不可删除！');
			return false;
		}else{
			$this->db->query("DELETE FROM tc_mall_comment WHERE itemid = '$itemid'");
			$this->db->query("UPDATE tc_mall SET comments = comments-1,orders = orders-1 WHERE itemid = '$mallid'");
			return true;
		}
	}

	function pingjia_commented($post){
		global $DT_TIME,$DT_IP;
		$linkurl = DT_PATH."mall/".$post['item_linkurl'];
		
		$write_members = trim($post["seled_members"]);
		$seled_members = substr($write_members,0,strlen($write_members)-1);//去除传送$post["seled_members"]字符串的最后一个字符“|”，作用：explode切割后不会有空的数组单元
		$seled_comments = substr($post["seled_comments"],0,strlen($post["seled_comments"])-1);

		$fen_members = explode("|",$seled_members);//将去除最后一个字符“|”后的字符串explode切割为数组
		$fen_comments = explode("|",$seled_comments);
		$fen_members_num = count($fen_members);
		$fen_comments_num = count($fen_comments);

		$mall_stat_num = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_mall_stat WHERE mallid = '$post[item_id]'");
		if($fen_members_num == 1 && $fen_comments_num == 1){
			$this->db->query("UPDATE tc_mall SET comments = comments+1 WHERE itemid = '$post[item_id]'");
			$this->db->query("INSERT INTO tc_mall_comment(itemid,mallid,buyer,seller,buyer_star,buyer_comment,buyer_ctime,buyer_reply,buyer_rtime,seller_star,seller_comment,seller_ctime,seller_reply,seller_rtime) VALUES ('','$post[item_id]','$seled_members','$post[item_username]','0','','0','','0','3','$seled_comments','$DT_TIME','','0')");
			if($mall_stat_num["num"] == 0){
				$this->db->query("INSERT INTO tc_mall_stat(mallid,seller,scomment,s1,s2,s3,buyer,bcomment,b1,b2,b3) VALUES ('$post[item_id]','$post[item_username]','1','0','0','1','','0','0','0','0')");
			}else{
				$this->db->query("UPDATE tc_mall_stat SET scomment=scomment+1,s3=s3+1 WHERE mallid = '$post[item_id]'");
			}
			/**************交易记录****************/
				$order_time = $DT_TIME-(rand(2,4)*24*60*60)+rand(3000,7000);
				$this->db->query("UPDATE tc_mall SET orders = orders+1 WHERE itemid = '$post[item_id]'");
				$this->db->query("INSERT INTO tc_mall_order (mallid,buyer,seller,title,linkurl,price,number,updatetime,status) VALUES ('$post[item_id]','$seled_members','$post[item_username]','$post[item_title]','$linkurl','1.01','1','$order_time','4')");
			/**************交易记录****************/
		}
		if($fen_members_num > 1 && $fen_comments_num > 1){
			if($mall_stat_num["num"] == 0){
				$this->db->query("INSERT INTO tc_mall_stat(mallid,seller,scomment,s1,s2,s3,buyer,bcomment,b1,b2,b3) VALUES ('$post[item_id]','$post[item_username]','0','0','0','0','','0','0','0','0')");
			}
			foreach($fen_members as $k=>$v){
				$DT_TIME_add = $DT_TIME + (rand(2,10)*24*60*60)+rand(3000,7000);
				$addtime = $k == 0?$DT_TIME:$DT_TIME_add;
				$order_time = $addtime-(rand(2,4)*24*60*60)+rand(3000,7000);
				$this->db->query("UPDATE tc_mall SET comments = comments+1,orders = orders+1 WHERE itemid = '$post[item_id]'");
				$this->db->query("INSERT INTO tc_mall_comment(itemid,mallid,buyer,seller,buyer_star,buyer_comment,buyer_ctime,buyer_reply,buyer_rtime,seller_star,seller_comment,seller_ctime,seller_reply,seller_rtime) VALUES ('','$post[item_id]','$v','$post[item_username]','0','','0','','0','3','$fen_comments[$k]','$addtime','','0')");
				$this->db->query("UPDATE tc_mall_stat SET scomment=scomment+1,s3=s3+1 WHERE mallid='$post[item_id]'");
				/**************交易记录****************/
				$this->db->query("INSERT INTO tc_mall_order (mallid,buyer,seller,title,linkurl,price,number,updatetime,status) VALUES ('$post[item_id]','$v','$post[item_username]','$post[item_title]','$linkurl','1.01','1','$order_time','4')");
				/**************交易记录****************/
			}
		}
		if($fen_members_num > $fen_comments_num){
			msg("请拟写跟选择评语数量一样多的会员名称！");
		}else if($fen_members_num < $fen_comments_num){
			msg("请选择跟拟写评价会员数量一样多的评语！");
		}
	}
/*产品评价*/
	
	function get_job_list($condition = 'itemid!=0',$order = 'edittime DESC'){
		//获取服务需求列表
		global $page,$pages,$pagesize,$offset,$items,$MOD;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_job WHERE $condition");
		$items = $r['num'];
		$pages = pages($items,$page,$pagesize);
		$job_lists = array();
		$result = $this->db->query("SELECT * FROM tc_job WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)){
			$job_lists[] = $r;
		}
		$join_result = $this->db->query("SELECT DISTINCT item_title FROM tc_comment");
		return $job_lists;
	}

	function get_product_list($condition = 'status=3'){
		global $MOD, $pages, $page, $pagesize, $offset, $items;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_mall WHERE $condition");
		$items = $r['num'];
		$pages = defined('CATID') ? listpages(1, CATID, $items, $page, $pagesize, 10, $MOD['linkurl']) : pages($items, $page, $pagesize);
		$lists = $catids = $CATS = array();
		$result = $this->db->query("SELECT * FROM tc_mall WHERE $condition ORDER BY addtime DESC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$r['alt'] = $r['title'];
			$r['title'] = set_style($r['title'], $r['style']);
			$r['userurl'] = userurl($r['username']);
			$r['linkurl'] = "/mall/".$r['linkurl'];
			$catids[$r['catid']] = $r['catid'];
			$lists[] = $r;
		}
		if($catids) {
			$result = $this->db->query("SELECT catid,catname,linkurl FROM {$this->db->pre}category WHERE catid IN (".implode(',', $catids).")");
			while($r = $this->db->fetch_array($result)) {
				$CATS[$r['catid']] = $r;
			}
			if($CATS) {
				foreach($lists as $k=>$v) {
					$lists[$k]['catname'] = $v['catid'] ? $CATS[$v['catid']]['catname'] : '';
					$lists[$k]['caturl'] = $v['catid'] ? $MOD['linkurl'].$CATS[$v['catid']]['linkurl'] : '';
				}
			}
		}
		return $lists;
	}

/*****  resume  *******/
	function get_resume_list(){
		global $MOD, $pages, $page, $pagesize, $offset, $items;
		$r = $this->db->get_one("SELECT COUNT(*) AS num FROM tc_resume ORDER BY edittime DESC");
		$items = $r['num'];
		$pages = pages($items,$page,$pagesize);
		$resum_lists = array();
		$result = $this->db->query("SELECT * FROM tc_resume ORDER BY edittime DESC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)){
			$resum_lists[] = $r;
		}
		return $resum_lists;
	}

	function person_do_resume_comment(){
		//获取产品中心评价模板
		$comments = array();
		$comments_result = $this->db->query("SELECT * FROM tc_person_do_comment_templates WHERE tem_class=3");
		while($r = $this->db->fetch_array($comments_result)){
			$comments[] = $r;
		}
		return $comments;
	}

	function person_do_resume_sel_member(){
		$members = array();
		$members_result = $this->db->query("SELECT * FROM tc_member");//WHERE groupid = '1' OR groupid = '8'
		while($r = $this->db->fetch_array($members_result)){
			$members[] = $r;
		}
		return $members;
	}

	function resume_commented($post){
		global $DT_TIME,$DT_IP;

		$write_members = trim($post["seled_members"]);
		$seled_members = substr($write_members,0,strlen($write_members)-1);//去除传送$post["seled_members"]字符串的最后一个字符“|”，作用：explode切割后不会有空的数组单元
		$seled_comments = substr($post["seled_comments"],0,strlen($post["seled_comments"])-1);

		$fen_members = explode("|",$seled_members);//将去除最后一个字符“|”后的字符串explode切割为数组
		$fen_comments = explode("|",$seled_comments);
		$fen_members_num = count($fen_members);
		$fen_comments_num = count($fen_comments);

		if($fen_members_num == 1 && $fen_comments_num == 1){
			$this->db->query("INSERT INTO tc_resume_comment (rc_id,item_id,from_username,star_attitude,star_time,star_quality,commented_time,content,agree,disagree,ip) VALUES ('','$post[itemid]','$seled_members','$post[star_attitude]','$post[star_time]','$post[star_quality]','$DT_TIME','$seled_comments','0','0','$DT_IP')");
			$this->db->query("UPDATE tc_resume SET new_comment_time = '$DT_TIME' WHERE itemid = '$post[itemid]'");
		}
		if($fen_members_num > 1 && $fen_comments_num > 1){
			foreach($fen_members as $k=>$v){
				if($k == 0){
					$this->db->query("INSERT INTO tc_resume_comment (rc_id,item_id,from_username,star_attitude,star_time,star_quality,commented_time,content,agree,disagree,ip) VALUES ('','$post[itemid]','$v','$post[star_attitude]','$post[star_time]','$post[star_quality]','$DT_TIME','$fen_comments[$k]','0','0','$DT_IP')");
				}else{
					$star_rand1 = rand(2,5);
					$star_rand2 = rand(2,5);
					$star_rand3 = rand(2,5);
					$this->db->query("INSERT INTO tc_resume_comment (rc_id,item_id,from_username,star_attitude,star_time,star_quality,commented_time,content,agree,disagree,ip) VALUES ('','$post[itemid]','$v','$star_rand1','$star_rand2','$star_rand3','$DT_TIME','$fen_comments[$k]','0','0','$DT_IP')");
				}
			}
			$this->db->query("UPDATE tc_resume SET new_comment_time = '$DT_TIME' WHERE itemid = '$post[itemid]'");
		}
		if($fen_members_num > $fen_comments_num){
			msg("请选择跟会员数一样多的评语！");
		}else if($fen_members_num < $fen_comments_num){
			msg("请选择跟评语数一样多的会员！");
		}
	}
/*****  resume  *******/

}
?>