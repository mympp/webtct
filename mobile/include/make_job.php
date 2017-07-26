<?php
/*
time:2015/10/27
who ：xiaolv
rel : make_job.htm
add:发布设备维修信息
*/
require_once '../common.inc.php';
error_reporting(E_ALL);
captcha($captcha,'2',false,$MODULE[1]['linkurl'].'wap/index.php?moduleid=9&itemid='.$_POST['servceid'].'&action=resume&make_job=true',$wap);
if($_SERVER['REQUEST_METHOD']=='POST'&&$_username){

	$query = "SELECT * FROM ".$DT_PRE."member WHERE username = '$_username'";
	$the_user = $db->get_one($query);

	$cates = ','.$_POST['catid'].',';
	$title = $_POST['title'];
	$catid = $_POST['catid'];
	$areaid = $the_user['areaid'];
	$truename = $the_user['truename'];
	$skill = '';
	$gender = $the_user['gender'];
	$marriage = 1;
	$age = '1';
	$birthday = '1980-01-01';
	$height = '';
	$weight = '';
	$major = '';
	$education = '';
	$language = '';
	$type = '1';
	$minsalary = '0';
	$maxsalary = '0';
	$experience = '0';
	$content = $_POST['content'];
	$mobile = '';
	$email = $the_user['email'];
	$telephone = $the_user['mobile'];
	$address = '';
	$open = '3';
	$template = '';
	$ip = $DT_IP;
	$time = time();
	$dt_time = date('Y-m-d',$time);
	$linkurl = 'job.php?itemid='.$the_user['userid'];
	$query = "INSERT INTO ".$DT_PRE."job SET 
		catid = '$catid',areaid='$areaid',
		level = 0, title = '$title', style='',fee ='0',introduce = '$content',
		keyword ='$title', total=1, maxsalary = 0,minsalary=0,  type=0,
		gender ='$gender',marriage = '0', education = 0,experience =0,
		minage=18,maxage=0,hits=0,apply=0,username = '$_username',
		groupid='$the_user[groupid]', company = '$the_user[company]',
		vip=0,validated1='0',truename='$the_user[truename]',telephone='$the_user[mobile]',address='$address',sex='1',totime='0',
		editor = '$_username',edittime = '$time',editdate='$dt_time',
		addtime='$time',adddate='$dt_time',ip = '$ip',linkurl = '$linkurl',
		step=4,validated='1',cates='$cates',hyd='0',new_comment_time='0',status=3
		";
	$res = $db->query($query);
	if($res){
		$the_itemid = $db->insert_id();
		$query = "INSERT INTO ".$DT_PRE."job_data SET itemid = '$the_itemid',content='$content'";
		if($db->query($query)){
			$forward = $MODULE[1]['linkurl'].'wap/wap_select.php?itemid='.$_POST['servceid'].'&wap=1';
			message('创建技术服务信息成功',$forward,3,$wap);
		}
	}

}
include template('make_job','touch');
?>
