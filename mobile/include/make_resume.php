<?php
/*
time:2015/10/27
who ：xiaolv
rel : make_resume.htm
add:发布工程师简历信息
*/
require_once '../common.inc.php';
error_reporting(E_ALL);
captcha($captcha,'1',false,$MODULE[1]['linkurl'].'wap/index.php?moduleid=9&itemid='.$_POST['servceid'].'&make_resume=true',$wap);
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
	$adress = '';
	$open = '3';
	$template = '';
	$ip = $DT_IP;
	$time = time();
	$linkurl = 'resum.php?itemid='.$the_user['userid'];
	$query = "INSERT INTO ".$DT_PRE."resume SET 
		catid = '$catid',areaid='$areaid',
		level = 0, title = '$title', fee ='0',introduce = '$content',
		keyword ='$title', truename = '$truename', gender ='$gender',
		birthday = '$birthday', age='$age',marriage = '$marriage', height = 0,skill= '$skill',
		weight = 0, education = 0, school='个体', major = '',
		maxsalary = 0,minsalary=0, type=0,
		experience =0, mobile = '$mobile',  email = '$email', username= '$_username',
		addtime = '$time', editor = '$_username', edittime = '$time',
		ip = '$ip',situation =0, status =3, open = 3, linkurl = '$linkurl',cates='$cates',talent='0',validated='0'
		";
		$res = $db->query($query);
		if($res){
			$the_itemid = $db->insert_id();
			$query = "INSERT INTO ".$DT_PRE."resume_data SET itemid = '$the_itemid',content='$content'";
			if($db->query($query)){
				$forward = $MODULE[9]['linkurl'].'apply.php?itemid='.$_POST['servceid'].'&wap=1';
				message('创建技术服务信息成功',$forward,3,$wap);
			}
		}

}

?>
