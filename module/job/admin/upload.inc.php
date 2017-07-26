
<!--
time:2015--7-29
who:陈韬
where：行88到92
what:修改发布人信息信息
relation:
关联数据库：
-->


<?php
defined('IN_DESTOON') or exit('Access Denied');
function input_csv($handle) {   //读取csv内容
setlocale(LC_ALL, 'zh_CN');   //linux下解决中文乱码或不全问题
     $out = array ();
     $n = 0;
     while ($data = fgetcsv($handle, 10000)) {
          $num = count($data);
          for ($i = 0; $i < $num; $i++) {
          	$out[$n][$i]=iconv('gb2312','utf-8',$data[$i]);
             //  $out[$n][$i] = $data[$i];
          }
          $n++;
     }
     return $out;
}

if($upload_type=="fuwu"){
$menus = array (
    array('添加服务需求', '?moduleid='.$moduleid.'&action=add'),
    array('服务需求列表', '?moduleid='.$moduleid),
    array('审核服务需求', '?moduleid='.$moduleid.'&action=check'),
    array('过期服务需求', '?moduleid='.$moduleid.'&action=expire'),
    array('未通过的需求', '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动服务需求', '?moduleid='.$moduleid.'&action=move'),
);
}else if($upload_type=="jishu"){
$menus = array (
    array('添加简历', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('简历列表', '?moduleid='.$moduleid.'&file='.$file),
    array('审核简历', '?moduleid='.$moduleid.'&file='.$file.'&action=check'),
    array('未通过简历', '?moduleid='.$moduleid.'&file='.$file.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&file='.$file.'&action=recycle'),
    array('移动简历', '?moduleid='.$moduleid.'&file='.$file.'&action=move'),
);
}
$action=isset($action)?$action:"";

if($action==""){

$upload_success=1;
$upload_type_right=1;
if(empty($_FILES['upload_csv']['tmp_name'])){
	$upload_success=0;
}else{
	$lastdot=strrpos($_FILES['upload_csv']['name'],".");//找到区分文件名与扩展名的标记符“.”最后出现的位置
	$extended=substr($_FILES['upload_csv']['name'],$lastdot+1);//取出扩展名
	if($extended!='csv'){
		$upload_type_right=0;
	}
}
//$file=$_FILES['upload_csv'];
include tpl('upload',$module);
}else if($action=='insert'){
	$num=isset($num)? intval($num):0;
	if($num==0){
		msg('无数据');
	}else{
		if($upload_type=="fuwu"){      //服务需求添加
			require MD_ROOT.'/job.class.php';
			$do = new job($moduleid);
			$back=true;
			foreach($_POST['post'] as $i=>$send){
				$p=array();
				foreach($send as $k=>$v){
					$p[$k]=$v;
				}
			$p['status']=2;      //待审核状态
			
			$areaname=$p['areaid'];
			$areaid=$db->get_one("select areaid from ".$DT_PRE."area where areaname like '%$areaname%'");  //搜索地区id
			
			$username=$p['username'];      //获取发表需求用户信息
			$user=userinfo($p['username']);
			$mobile=$db->get_one("select mobile from ".$DT_PRE."member where username = '".$username."'");
			$p['truename']=$user['truename'];
			$p['sex']=$user['gender'];
			$p['telephone']=$user['telephone'];
			$p['mobile']=$mobile['mobile'];
			$p['email']=$user['email'];
			if(count($areaid)>0){
				$p['areaid']=$areaid['areaid'];
			}else{
				$p['areaid']=0;
			}
			if(!$do->add($p)){
				$back=false;
			}
			}
			if($back){
				msg('添加成功',"?moduleid=$moduleid&action=check");
			}
		}else if($upload_type=="jishu"){                 //技术供应添加
			require MD_ROOT.'/resume.class.php';
			$do = new resume($moduleid);
			$back=true;
			require DT_ROOT.'/include/upload.class.php';
			//require DT_ROOT.'/include/db_mysql.class.php';
			$str_dir_month=DT_ROOT.'/file/upload/'.date('Ym',time()).'/';      //月文件夹
			$str_dir=DT_ROOT.'/file/upload/'.date('Ym/d',time()).'/';     //保存地址
			$str_url=DT_PATH.'file/upload/'.date('Ym/d',time()).'/';
			foreach($_POST['post'] as $i=>$send){
			
			$p=array();
			foreach($send as $k=>$v){
				$p[$k]=$v;
			}
			if(!empty($_FILES['photo_'.$i]['tmp_name'])){
				if(!is_dir($str_dir_month)){
					mkdir($str_dir_month);
				}
				if(!is_dir($str_dir)){
					mkdir($str_dir);
				}
				$UP=new upload($_FILES['photo_'.$i],$str_dir,$_FILES['photo_'.$i]['tmp_name']);
				$UP->set_savename();
				$last_dot=strrpos($_FILES['photo_'.$i]['name'],".");
				$extend_pot=substr($_FILES['photo_'.$i]['name'],$last_dot+1);
				if( move_uploaded_file($_FILES['photo_'.$i]['tmp_name'],$str_dir.$UP->savename.$extend_pot))//保存图片
				{
					unset($_FILES['photo_'.$i]);
				}else{
			
				}
				$p['thumb']=$str_url.$UP->savename.$extend_pot;    //logo地址
			}		
			
			$birth=explode('/',$p['birthday']);    //处理日期
			$p['byear']=$birth[0];
			$p['bmonth']=$birth[1];
			$p['bday']=$birth[2];
			
			
			$p['status']=2;           //审核状态
			
			$areaname=$p['areaid'];          //地区id
			$areaid=$db->get_one("select areaid from ".$DT_PRE."area where areaname like '%$areaname%'");
				//echo $areaid['areaid'];
				if(count($areaid)>0){
					$p['areaid']=$areaid['areaid'];
				}else{
					$p['areaid']=0;
				}
			
				if(!$do->add($p)){
					$back=false;
				}
			}
			if($back){
				msg('添加成功',"?moduleid=$moduleid&file=resume&action=check");
			}

			
		}
		
	}
}


?>
