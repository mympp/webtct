<?php
/*
	2015-12-2 简历导出功能
	2015-12-30 简历增加：教育经历、学生信息、培训经历、语言能力、工作经历模块
*/
defined('DT_ADMIN') or exit('Access Denied');
$table = $DT_PRE.'hr_resume';
require MD_ROOT.'/resume.class.php';
$do = new resume($moduleid);
$menus = array (
    array('添加简历', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('简历列表', '?moduleid='.$moduleid.'&file='.$file),
    array('审核简历', '?moduleid='.$moduleid.'&file='.$file.'&action=check'),
    array('未通过简历', '?moduleid='.$moduleid.'&file='.$file.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&file='.$file.'&action=recycle'),
    array('移动简历', '?moduleid='.$moduleid.'&file='.$file.'&action=move'),
);

if(in_array($action, array('add', 'edit'))) {
	$FD = cache_read('fields-'.substr($table, strlen($DT_PRE)).'.php');
	if($FD) require DT_ROOT.'/include/fields.func.php';
	isset($post_fields) or $post_fields = array();
}

if(in_array($action, array('', 'check', 'expire', 'reject', 'recycle'))) {
	$GENDER[0] = '性别';
	$TYPE[0] = '工作';
	$MARRIAGE[0] = '婚姻';
	$EDUCATION[0] = '学历';
	$sfields = array('模糊', '标题', '简介', '会员名', '真实姓名', '毕业院校', '所学专业', '专业技能', '语言水平', '联系手机', '联系电话', '联系地址', 'Email', 'MSN', 'QQ', '模板', 'IP');
	$dfields = array('keyword', 'title', 'introduce', 'username', 'truename', 'school', 'major', 'skill', 'language', 'mobile', 'telephone', 'address', 'email', 'msn', 'qq','template', 'ip');
	$sorder  = array('结果排序方式', '更新时间降序', '更新时间升序', '添加时间降序', '添加时间升序', '浏览次数降序', '浏览次数升序', '最低待遇降序', '最低待遇升序', '最高待遇降序', '最高待遇升序', '学历高低降序', '学历高低升序', '信息ID降序', '信息ID升序');
	$dorder  = array($MOD['order'], 'edittime DESC', 'edittime ASC', 'addtime DESC', 'addtime ASC', 'hits DESC', 'hits ASC', 'minsalary DESC', 'minsalary ASC', 'maxalary DESC', 'maxsalary ASC', 'education DESC', 'education ASC', 'itemid DESC', 'itemid ASC');

	$level = isset($level) ? intval($level) : 0;
	$gender = isset($gender) ? intval($gender) : 0;
	$type = isset($type) ? intval($type) : 0;
	$marriage = isset($marriage) ? intval($marriage) : 0;
	$education = isset($education) ? intval($education) : 0;
	$experience = isset($experience) ? intval($experience) : 0;
	$areaid = isset($areaid) ? intval($areaid) : 0;
	$minsalary = isset($minsalary) ? intval($minsalary) : 0;
	$maxsalary = isset($maxsalary) ? intval($maxsalary) : 0;
	$open = isset($open) ? intval($open) : 0;
	$thumb = isset($thumb) ? intval($thumb) : 0;

	isset($fields) && isset($dfields[$fields]) or $fields = 0;
	isset($order) && isset($dorder[$order]) or $order = 0;
	
	isset($datetype) && in_array($datetype, array('edittime', 'addtime', 'totime')) or $datetype = 'edittime';
	$fromdate = isset($fromdate) && is_date($fromdate) ? $fromdate : '';
	$fromtime = $fromdate ? strtotime($fromdate.' 0:0:0') : 0;
	$todate = isset($todate) && is_date($todate) ? $todate : '';
	$totime = $todate ? strtotime($todate.' 23:59:59') : 0;

	$areaid = isset($areaid) ? intval($areaid) : 0;
	$itemid or $itemid = '';

	$fields_select = dselect($sfields, 'fields', '', $fields);
	$level_select = level_select('level', '级别', $level);
	$order_select  = dselect($sorder, 'order', '', $order);

	$condition = '';
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CATEGORY[$catid]['child']) ? " AND catid IN (".$CATEGORY[$catid]['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($AREA[$areaid]['child']) ? " AND areaid IN (".$AREA[$areaid]['arrchildid'].")" : " AND areaid=$areaid";
	if($level) $condition .= " AND level=$level";
	if($gender) $condition .= " AND gender=$gender";
	if($type) $condition .= " AND type=$type";
	if($marriage) $condition .= " AND marriage=$marriage";
	if($education) $condition .= " AND education>=$education";
	if($experience) $condition .= " AND experience>=$experience";
	if($minsalary) $condition .= " AND minsalary>=$minsalary";
	if($maxsalary) $condition .= " AND maxsalary<=$maxsalary";
	if($open) $condition .= " AND open=$open";
	if($thumb) $condition .= " AND thumb<>''";
	if($fromtime) $condition .= " AND `$datetype`>=$fromtime";
	if($totime) $condition .= " AND `$datetype`<=$totime";
	if($itemid) $condition .= " AND itemid=$itemid";

	$timetype = strpos($dorder[$order], 'add') !== false ? 'add' : '';
}

switch($action) {
	case 'add':
		//教育经历,学生信息,培训经历,语言能力,工作经历的id
		$post['education_id']=isset($_SESSION['education_id'])?$_SESSION['education_id']:'';
		$post['information_id']=isset($_SESSION['information_id'])?$_SESSION['information_id']:'';
		$post['experience_id']=isset($_SESSION['experience_id'])?$_SESSION['experience_id']:'';
		$post['train_id']=isset($_SESSION['train_id'])?$_SESSION['train_id']:'';
		$post['language_id']=isset($_SESSION['language_id'])?$_SESSION['language_id']:'';
		//每次添加完数据后,清空在session中的教育经历,学生信息,培训经历,语言能力,工作经历的id
		$_SESSION['education_id']=null;
		$_SESSION['information_id']=null;
		$_SESSION['experience_id']=null;
		$_SESSION['train_id']=null;
		$_SESSION['language_id']=null;
		//结束
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				$do->add($post);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				//结束
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action);
			} else {
				msg($do->errmsg);
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$content = '';
			$status = 3;
			$addtime = timetodate($DT_TIME);
			$gender = 1;
			$byear = 19;
			$bmonth = $bday = $experience = $marriage = $type = 1;
			$education = 3;
			$minsalary = 1000;
			$maxsalary = 0;
			$open = 3;
			$item = array();
			$menuid = 0;
			isset($url) or $url = '';
			if($url) {
				$tmp = fetch_url($url);
				if($tmp) extract($tmp);
			}
			include tpl('resume_edit', $module);
		}
	break;
	//简历批量导出功能
	case 'derive':
		include tpl('derive',$module);
		break;
	//人才网模块增加
	case 'add_all':
		$type=isset($_REQUEST['type'])?$_REQUEST['type']:'';
		switch($type){
			//增加教育经历
			case 'education':
				$education_id=isset($_GET['education_id'])?$_GET['education_id']:'';
				$itemid=isset($_GET['itemid'])?$_GET['itemid']:'';
				include tpl('resume_education',$module);
				break;
			case 'add_education':
				//添加教育经历
				$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
				$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
				$school_name=isset($_POST['school_name'])?$_POST['school_name']:'';
				$s_major=isset($_POST['s_major'])?$_POST['s_major']:'';
				$s_education=isset($_POST['s_education'])?$_POST['s_education']:'';
				$s_address=isset($_POST['s_address'])?$_POST['s_address']:'';
				$ed_describe=isset($_POST['ed_describe'])?$_POST['ed_describe']:'';
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
				$a=$db->query("insert into {$db->pre}hr_resume_education values('null','$start_time','$stop_time','$school_name','$s_major','$s_education','$s_address','$ed_describe',0)");
				$education=mysql_insert_id().',';
				if($a){
					$_SESSION['education_id']=isset($_POST['education_id'])?$_POST['education_id'].$education:$education;
					echo $education;
					//echo $_SESSION['education_id'];
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
				$s_address=$_POST['s_address'];
				$ed_describe=isset($_POST['ed_describe'])?$_POST['ed_describe']:'';
				$education_id=trim($_POST['id'],',');
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
					$_SESSION['education_id']=str_replace($education_id.',','',$_SESSION['education_id']);
					echo "education";
				}else{
					echo "删除失败！";
				}
			break;
			//教育经历结束

			//学生信息
			case 'student_information':
				$information_id=isset($_GET['information_id'])?$_GET['information_id']:'';
				include tpl('resume_student_information',$module);	
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
					$_SESSION['information_id']=isset($_POST['information_id'])?$_POST['information_id'].$information_id:$information_id;
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
					$_SESSION['information_id']=str_replace($information_id.',','',$_SESSION['information_id']);
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
			//学生信息结束
			//工作经历
			case 'experience':
				$education_id=isset($_GET['experience_id'])?$_GET['experience_id']:'';
				include tpl('resume_experience',$module);
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
					$_SESSION['experience_id']=isset($_POST['experience_id'])?$_POST['experience_id'].$experience_id:$experience_id;
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
					$b=$db->query("update {$db->pre}hr_resume set  experience_id='$experience_id_all' where itemid='$itemid'");
				}
				$a=$db->query("DELETE FROM {$db->pre}hr_resume_experience WHERE experience_id=$experience_id limit 1");
				if($a){
					$_SESSION['experience_id']=str_replace($experience_id.',','',$_SESSION['experience_id']);
					echo "experience";
				}else{
					echo "删除失败！";
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
			//工作经历结束
			//培训经历
			case 'train':
				$train_id=isset($_GET['train_id'])?$_GET['train_id']:'';
				include tpl('resume_train',$module);
				break;
			//添加培训经历
			case 'add_train':
				$start_time=isset($_POST['start_time'])?$_POST['start_time']:'';
				$stop_time=isset($_POST['stop_time'])?$_POST['stop_time']:'';
				$school_name=isset($_POST['school_name'])?$_POST['school_name']:'';
				$s_major=isset($_POST['s_major'])?$_POST['s_major']:'';
				$s_education=isset($_POST['s_education'])?$_POST['s_education']:'';
				$s_address=isset($_POST['s_address'])?$_POST['s_address']:'';
				$ed_describe=isset($_POST['ed_describe'])?$_POST['ed_describe']:'';
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
				$a=$db->query("insert into {$db->pre}hr_resume_education values('null','$start_time','$stop_time','$school_name','$s_major','$s_education','$s_address','$ed_describe',1)");
				$train_id=mysql_insert_id().',';
				if($a){
					$_SESSION['train_id']=isset($_POST['train_id'])?$_POST['train_id'].$train_id:$train_id;
					echo $train_id;
				}else{
					echo "保存失败！";
				}	
			break;
			//修改培训经历	
			case 'update_train':
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
			//删除培训经历
			case 'del_train':
				$train_id_all=str_replace($_POST['id'],'',$_POST['train_id']);
				$train_id=trim($_POST['id'],',');
				$itemid=isset($_POST['itemid'])?$_POST['itemid']:'';
				if($itemid){
					$b=$db->query("update {$db->pre}hr_resume set train_id='$train_id_all' where itemid='$itemid'");
				}	
				
				$a=$db->query("DELETE FROM {$db->pre}hr_resume_education WHERE education_id=$train_id limit 1");
				if($a){
					$_SESSION['train_id']=str_replace($train_id.',','',$_SESSION['train_id']);
					echo "train";
				}else{
					echo "删除失败！";
				}
			break;
			//培训经历结束
			//语言能力
			case 'language':
				$language_id=isset($_GET['language_id'])?$_GET['language_id']:'';
				include tpl('resume_language',$module);
				break;
			//添加语言能力
			case 'add_language':
				$catetory=$_POST['catetory'];
				$grasp=$_POST['grasp'];
				$r_write=$_POST['r_write'];
				$l_say=$_POST['l_say'];
				$grade=$_POST['grade'];
				$a=$db->query("insert into {$db->pre}hr_resume_language values('null','$catetory','$grasp','$r_write','$l_say','$grade')");
				$language_id=mysql_insert_id().',';
				if($a){
					$_SESSION['language_id']=isset($_POST['language_id'])?$_POST['language_id'].$language_id:$language_id;
					echo $language_id;
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
					$_SESSION['language_id']=str_replace($language_id.',','',$_SESSION['language_id']);
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
			//语言能力结束
			
		}
	break;
	
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		//教育经历,学生信息,培训经历,语言能力,工作经历的id
		$post['education_id']=isset($_SESSION['education_id'])?$_SESSION['education_id']:'';
		$post['information_id']=isset($_SESSION['information_id'])?$_SESSION['information_id']:'';
		$post['experience_id']=isset($_SESSION['experience_id'])?$_SESSION['experience_id']:'';
		$post['train_id']=isset($_SESSION['train_id'])?$_SESSION['train_id']:'';
		$post['language_id']=isset($_SESSION['language_id'])?$_SESSION['language_id']:'';
		//每次添加完数据后,清空在session中的教育经历,学生信息,培训经历,语言能力,工作经历的id
		$_SESSION['education_id']=null;
		$_SESSION['information_id']=null;
		$_SESSION['experience_id']=null;
		$_SESSION['train_id']=null;
		$_SESSION['language_id']=null;
		//结束
		if($submit) {
			if($do->pass($post)) {
				if($FD) fields_check($post_fields);
				if($FD) fields_update($post_fields, $table, $do->itemid);
				$do->edit($post);
				//每次添加完数据后,清空在session中的教育经历,学生信息,培训经历,语言能力,工作经历的id
				$_SESSION['education_id']=null;
				$_SESSION['information_id']=null;
				$_SESSION['experience_id']=null;
				$_SESSION['train_id']=null;
				$_SESSION['language_id']=null;
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$item = $do->get_one();
			extract($item);
			$addtime = timetodate($addtime);
			list($byear, $bmonth, $bday) = explode('-', $birthday);
			$menuon = array('4', '3', '2', '1');
			$menuid = $menuon[$status];
			include tpl('resume_'.$action, $module);
		}
	break;
	case 'move':
		if($submit) {
			$fromids or msg('请填写来源ID');
			if($tocatid) {
				$db->query("UPDATE {$table} SET catid=$tocatid WHERE `{$fromtype}` IN ($fromids)");
				dmsg('移动成功', $forward);
			} else {
				msg('请选择目标分类');
			}
		} else {
			$itemid = $itemid ? implode(',', $itemid) : '';
			$menuid = 5;
			include tpl($action);
		}
	break;
	case 'update':
		is_array($itemid) or msg('请选择简历');	
		foreach($itemid as $v) {
			$do->update($v);
		}
		dmsg('更新成功', $forward);
	break;
	case 'delete':
		$itemid or msg('请选择简历');
		isset($recycle) ? $do->recycle($itemid) : $do->delete($itemid);
		dmsg('删除成功', $forward);
	break;
	case 'restore':
		$itemid or msg('请选择简历');
		$do->restore($itemid);
		dmsg('还原成功', $forward);
	break;
	case 'refresh':
		$itemid or msg('请选择简历');
		$do->refresh($itemid);
		dmsg('刷新成功', $forward);
	break;
	case 'clear':
		$do->clear();
		dmsg('清空成功', $forward);
	break;
	case 'level':
		$itemid or msg('请选择简历');
		$level = intval($level);
		$do->level($itemid, $level);
		dmsg('级别设置成功', $forward);
	break;
	case 'recycle':
		$lists = $do->get_list('status=0'.$condition);
		$menuid = 4;
		include tpl('resume_index', $module);
	break;
	case 'reject':
		if($itemid && !$psize) {
			$do->reject($itemid);
			dmsg('拒绝成功', $forward);
		} else {
			$lists = $do->get_list('status=1'.$condition);
			$menuid = 3;
			include tpl('resume_index', $module);
		}
	break;
	case 'check':
		if($itemid && !$psize) {
			$do->check($itemid);
			dmsg('审核成功', $forward);
		} else {
			$lists = $do->get_list('status=2'.$condition);
			$menuid = 2;
			include tpl('resume_index', $module);
		}
	break;
	default:
		$lists = $do->get_list('status=3'.$condition);
		$menuid = 1;
		include tpl('resume_index', $module);
	break;
}
?>