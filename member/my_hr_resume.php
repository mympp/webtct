<?php
/*
time:2016-1-8
who:周创杰
where:人才网新增模块
relation:template\tc\member\my_hr_resume.htm(57-754行，1058-1323行),tiancheng\member\my_hr_resume.php(为新增脚本)
*/
require 'config.inc.php';
require '../common.inc.php';
if($DT_BOT) dhttp(403);
$action=$_GET['action'];
switch($action){
	//添加教育经历,培训经历
	case 'add_education':
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$school_name=isset($_POST['school_name'])?$_POST['school_name']:'';
		$s_major=isset($_POST['s_major'])?$_POST['s_major']:'';
		$s_education=isset($_POST['s_education'])?$_POST['s_education']:'';
		$s_address=isset($_POST['s_address'])?$_POST['s_address']:'';
		$ed_describe=isset($_POST['ed_describe'])?$_POST['ed_describe']:'';
		$category=$_POST['category'];//0代表教育经历,1代表培训经历
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($school_name)){
			echo "02";
			exit;
		}
		if(empty($s_major)){
			echo "03";
			exit;
		}
		if(empty($s_education)){
			echo "04";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("insert into {$db->pre}hr_resume_education values('null','$start_time','$stop_time','$school_name','$s_major','$s_education','$s_address','$ed_describe','$category')");
		$education=mysql_insert_id().',';
		if($a){
			echo $education;
		}else{
			echo "保存失败！";
		}	
	break;
	//修改教育经历	
	case 'update_education':
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$school_name=isset($_POST['school_name'])?$_POST['school_name']:'';
		$s_major=isset($_POST['s_major'])?$_POST['s_major']:'';
		$s_education=isset($_POST['s_education'])?$_POST['s_education']:'';
		$s_address=isset($_POST['s_address'])?$_POST['s_address']:'';
		$ed_describe=isset($_POST['ed_describe'])?$_POST['ed_describe']:'';
		$education_id=trim($_POST['id'],',');
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($school_name)){
			echo "02";
			exit;
		}
		if(empty($s_major)){
			echo "03";
			exit;
		}
		if(empty($s_education)){
			echo "04";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("update {$db->pre}hr_resume_education set start_time='$start_time',stop_time='$stop_time',school_name='$school_name',major='$s_major',education='$s_education',address='$s_address',ed_describe='$ed_describe' where education_id=$education_id");
		if($a){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	break;
	//删除教育经历
	case 'del_education':
		$education_id_all=str_replace($_POST['id'],'',$_POST['education_id']);
		$education_id=trim($_POST['id'],',');
		$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
		if($itemid){
			$b=$db->query("update {$db->pre}hr_resume set  education_id='$education_id_all' where itemid='$itemid'");
		}	
		$a=$db->query("DELETE FROM {$db->pre}hr_resume_education WHERE education_id=$education_id limit 1");
		if($a){
			echo "education";
		}else{
			echo "删除失败！";
		}
	break;
	//删除培训经历
	case 'del_train':
		$train_id_all=str_replace($_POST['id'],'',$_POST['train_id']);
		$education_id=trim($_POST['id'],',');
		$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
		if($itemid){
			$b=$db->query("update {$db->pre}hr_resume set  train_id='$train_id_all' where itemid='$itemid'");
		}			
		$a=$db->query("DELETE FROM {$db->pre}hr_resume_education WHERE education_id=$education_id limit 1");
		if($a){
			echo "train";
		}else{
			echo "删除失败！";
		}
	break;
	//添加工作经历
	case 'insert_experience':
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$industry=isset($_POST['industry'])?$_POST['industry']:'';
		$company_name=isset($_POST['company_name'])?$_POST['company_name']:'';
		$s_scale=isset($_POST['s_scale'])?$_POST['s_scale']:'';
		$company_nature=isset($_POST['company_nature'])?$_POST['company_nature']:'';
		$work_nature=isset($_POST['work_nature'])?$_POST['work_nature']:'';
		$describe=isset($_POST['describe'])?$_POST['describe']:'';
		$position=isset($_POST['position'])?$_POST['position']:'';
		$pay=intval(isset($_POST['pay'])?$_POST['pay']:'');
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($industry)){
			echo "02";
			exit;
		}
		if(empty($company_name)){
			echo "03";
			exit;
		}
		if(empty($position)){
			echo "06";
			exit;
		}
		if(empty($pay)){
			echo "07";
			exit;
		}
		if(empty($describe)){
			echo "04";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("insert into {$db->pre}hr_resume_experience values('null','$start_time','$stop_time','$industry','$company_name','$s_scale','$company_nature','$work_nature','$describe','$position','$pay')");
		$experience_id=mysql_insert_id().',';
		if($a){
			echo $experience_id;
		}else{
			echo "保存失败！";
		}
	break;
	//删除工作经历
	case 'del_experience':
		$experience_id_all=str_replace($_POST['id'],'',$_POST['experience_id']);
		$experience_id=trim($_POST['id'],',');
		$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
		if($itemid){
			$b=$db->query("update {$db->pre}hr_resume set experience_id='$experience_id_all' where itemid='$itemid'");
		}		
		$a=$db->query("DELETE FROM {$db->pre}hr_resume_experience WHERE experience_id='$experience_id' limit 1");
		if($a){
			echo "experience";
		}else{
			echo "删除失败111！";
		}
	break;
	//修改工作经历
	case 'update_experience':
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$industry=isset($_POST['industry'])?$_POST['industry']:'';
		$company_name=isset($_POST['company_name'])?$_POST['company_name']:'';
		$s_scale=isset($_POST['s_scale'])?$_POST['s_scale']:'';
		$company_nature=isset($_POST['company_nature'])?$_POST['company_nature']:'';
		$work_nature=isset($_POST['work_nature'])?$_POST['work_nature']:'';
		$describe=isset($_POST['describe'])?$_POST['describe']:'';
		$experience_id=trim($_POST['id'],',');
		$position=isset($_POST['position'])?$_POST['position']:'';
		$pay=intval(isset($_POST['pay'])?$_POST['pay']:'');
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($industry)){
			echo "02";
			exit;
		}
		if(empty($company_name)){
			echo "03";
			exit;
		}
		if(empty($position)){
			echo "06";
			exit;
		}
		if(empty($pay)){
			echo "07";
			exit;
		}
		if(empty($describe)){
			echo "04";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("update {$db->pre}hr_resume_experience set start_time='$start_time',stop_time='$stop_time',industry='$industry',company_name='$company_name',scale='$s_scale',company_nature='$company_nature',work_nature='$work_nature',ex_describe='$describe',position='$position',pay='$pay' where experience_id=$experience_id");
		if($a){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	break;
	//添加学生信息
	case 'insert_student_information':
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$category=isset($_POST['category'])?$_POST['category']:'';//0代表获得奖励，1代表校内职务，2代表实践经验
		$value=isset($_POST['value'])?$_POST['value']:'';
		$practice=isset($_POST['practice'])?$_POST['practice']:'';
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($value)){
			echo "02";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("insert into {$db->pre}hr_resume_student_information values('null','$start_time','$stop_time','$value','$practice','$category')");
		$information_id=mysql_insert_id().',';
		if($a){
			echo $information_id;
		}else{
			echo "保存失败！";
		}
	break;
	//删除学生信息
	case 'del_student_information':
		$information_id_all=str_replace($_POST['id'],'',$_POST['information_id']);
		$information_id=trim($_POST['id'],',');
		$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
		if($itemid){
			$b=$db->query("update {$db->pre}hr_resume set  information_id='$information_id_all' where itemid='$itemid'");
		}
		$a=$db->query("DELETE FROM {$db->pre}hr_resume_student_information WHERE information_id=$information_id limit 1");
		if($a){
			echo "student_information";
		}else{
			echo "删除失败！";
		}
	break;
	//修改学生信息
	case 'update_student_information':
		$information_id=trim($_POST['id'],',');
		$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
		$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
		$category=isset($_POST['category'])?$_POST['category']:'';//0代表获得奖励，1代表校内职务，2代表实践经验
		$value=isset($_POST['value'])?$_POST['value']:'';
		$practice=isset($_POST['practice'])?$_POST['practice']:'';
		if(empty($start_time)){
			echo "00";
			exit;
		}
		if(empty($stop_time)){
			echo "01";
			exit;
		}
		if(empty($value)){
			echo "02";
			exit;
		}
		if(strtotime($start_time)>strtotime($stop_time)){
			echo "05";
			exit;
		}
		$a=$db->query("update {$db->pre}hr_resume_student_information set start_time='$start_time',stop_time='$stop_time',value='$value',practice='$practice',sn_category='$category' where information_id=$information_id");
		if($a){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	break;
	//添加语言能力
	case 'add_language':
		$catetory=$_POST['catetory'];
		$grasp=$_POST['grasp'];
		$r_write=$_POST['r_write'];
		$l_say=$_POST['l_say'];
		$grade=$_POST['grade'];
		$a=$db->query("insert into {$db->pre}hr_resume_language values('null','$catetory','$grasp','$r_write','$l_say','$grade')");
		$information_id=mysql_insert_id().',';
		if($a){
			echo $information_id;
		}else{
			echo "保存失败！";
		}
	break;
	//删除语言能力
	case 'del_language':
		$language_id_all=str_replace($_POST['id'],'',$_POST['language_id']);
		$language_id=trim($_POST['id'],',');
		$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
		if($itemid){
			$b=$db->query("update {$db->pre}hr_resume set language_id='$language_id_all' where itemid='$itemid'");
		}	
		$a=$db->query("DELETE FROM {$db->pre}hr_resume_language WHERE language_id=$language_id limit 1");
		if($a){
			echo "language";
		}else{
			echo "删除失败！";
		}
	break;
	//修改语言能力
	case 'update_language':
		$catetory=$_POST['catetory'];
		$grasp=$_POST['grasp'];
		$r_write=$_POST['r_write'];
		$l_say=$_POST['l_say'];
		$grade=$_POST['grade'];
		$language_id=trim($_POST['id'],',');
		$a=$db->query("update {$db->pre}hr_resume_language set catetory='$catetory',grasp='$grasp',r_write='$r_write',l_say='$l_say',grade='$grade' where language_id=$language_id");
		if($a){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	break;
}