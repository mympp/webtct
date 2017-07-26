<?php
/*
time:2015-5-27
who:陈韬
where：默认图片处理
what:添加save_photo函数、行93到105默认图片处理
relation:/module/mall/admin/template/upload.tpl.php
关联数据库：
*/

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

function save_photo($name){
	$str_dir_month=DT_ROOT.'/file/upload/'.date('Ym',time()).'/';      //月文件夹
	$str_dir=DT_ROOT.'/file/upload/'.date('Ym/d',time()).'/';     //保存地址
	$str_url=DT_PATH.'file/upload/'.date('Ym/d',time()).'/';
	if(!is_dir($str_dir_month)){
		mkdir($str_dir_month);
	}
	if(!is_dir($str_dir)){
		mkdir($str_dir);
	}
				
	$UP=new upload($_FILES[$name],$str_dir,$_FILES[$name]['tmp_name']);
	$UP->set_savename();
	$last_dot=strrpos($_FILES[$name]['name'],".");
	$extend_pot=substr($_FILES[$name]['name'],$last_dot+1);
	if( move_uploaded_file($_FILES[$name]['tmp_name'],"$str_dir.$UP->savename.$extend_pot"))//保存图片
	{
	}else{
					
	}
	return "$str_url.$UP->savename.$extend_pot";    //图片地址
}

if($upload_type=="product"){
$menus = array (
    array('添加商品', '?moduleid='.$moduleid.'&action=add'),
    array('商品列表', '?moduleid='.$moduleid),
    array('审核商品', '?moduleid='.$moduleid.'&action=check'),
    array('下架商品', '?moduleid='.$moduleid.'&action=expire'),
    array('未通过商品', '?moduleid='.$moduleid.'&action=reject'),
    array('回收站', '?moduleid='.$moduleid.'&action=recycle'),
    array('移动分类', '?moduleid='.$moduleid.'&action=move'),
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
		if($upload_type=="product"){      //商品添加
			require MD_ROOT.'/mall.class.php';
			require DT_ROOT.'/include/upload.class.php';
			//require DT_ROOT.'/include/db_mysql.class.php';
			$str_dir_month=DT_ROOT.'/file/upload/'.date('Ym',time()).'/';      //月文件夹
			$str_dir=DT_ROOT.'/file/upload/'.date('Ym/d',time()).'/';     //保存地址
			$str_url=DT_PATH.'file/upload/'.date('Ym/d',time()).'/';
			$do = new mall($moduleid);
			$back=true;
					
			//默认图片处理	
			$default_one_url='';
			$default_two_url='';
			$default_three_url='';
			if(!empty($_FILES['default_photo_one']['tmp_name'])){ //默认图片1
				$default_one_url=save_photo('default_photo_one');
			}
			if(!empty($_FILES['default_photo_two']['tmp_name'])){ //默认图片2
				$default_two_url=save_photo('default_photo_two');
			}
			if(!empty($_FILES['default_photo_three']['tmp_name'])){ //默认图片1
				$default_three_url=save_photo('default_photo_three');
			}
			
			foreach($_POST['post'] as $i=>$send){
				$p=array();
				foreach($send as $k=>$v){
					$p[$k]=$v;
				}
			$p['status']=2;      //待审核状态
			$p['stype']=1;        //商品属性分类为配件
			
			if(!empty($_FILES['photo_one_'.$i]['tmp_name'])){      //图片1处理
				$p['thumb']=save_photo('photo_one_'.$i);    //图片地址
			}else{
				$p['thumb']=$default_one_url;
			}
				
			if(!empty($_FILES['photo_two_'.$i]['tmp_name'])){      //图片2处理
				$p['thumb1']=save_photo('photo_two_'.$i);    //图片地址
			}else{
				$p['thumb1']=$default_two_url;
			}		
			
			if(!empty($_FILES['photo_three_'.$i]['tmp_name'])){      //图片3处理
				$p['thumb2']=save_photo('photo_three_'.$i);
			}else{
				$p['thumb2']=$default_three_url;
			}
			
			$username=$p['username'];      //获取发表需求用户信息
			$user=$db->get_one("select * from ".$DT_PRE."member where username = '".$username."'");
			$p['truename']=$user['truename'];
			$p['mobile']=$user['mobile'];
			
				
			if(!$do->add($p)){
				$back=false;
			}
			}
			if($back){
				msg('添加成功',"?moduleid=$moduleid&action=check");
			}
		}
		
	}
}

?>
