<?php
defined('IN_DESTOON') or exit('Access Denied');
require DT_ROOT.'/module/'.$module.'/common.inc.php';
if($u == ''){
	header('Location:'.DT_PATH.'search/index.php');exit;
}elseif(!empty($_GET['i']) && !empty($infotype)){			//普通地址跳转
require_once DT_ROOT.'/module/'.$module.'/info.class.php';
$sogex_info_type = get_cache('info_type');
$info=new info($sogex_info_type[$infotype]['catname']);
$info_data=$info->get_one($_GET['i']);
extract($info_data);
//修改点击次数
$post['hits'] = intval($hits)+1;
$info->update($post,$i);
}else{  //推广地址跳转
	if(empty($t)) header('Location:'.DT_PATH.'search/index.php');		//没有推广信息id，回首页
//查找推广内容
$sp = $db->get_one("select * from {$db->pre}spread where itemid = $t");		//被点击推广
$spend = 0;
$default_spend = 1;		//默认最低费用
$default_quality = 1;		//默认词质量度

if($sp['stype'] == '2'){	//单条推广类型进行扣费
	$now_spend = $default_spend; //当次点击需要花费
	$sp_next = $db->get_one("select * from {$db->pre}spread where spend < ".$sp['spend']." and status = 3 and spread_status = 3 and word = '".$sp['word']."' and stype = 2");
	if($sp_next){		//能获取下一个推广内容，按下一个推广的质量度和费用进行计算
		$now_spend = intval($sp_next['spend'])*intval($default_quality)/intval($default_quality)+0.01;
	}else{		//无下一个推广内容，按默认费用和质量度计算
		$now_spend = intval($default_spend)*intval($default_quality)/intval($default_quality)+0.01;
	}
	$new_least = intval($sp['least'])-intval($now_spend);
	$db->query("update {$db->pre}spread set least = $new_least where itemid = $t");	//扣除费用
	
	$spend = $now_spend;
}

//获取客户端ip
$ip = get_ip();

//插入推广点击记录
$db->query("insert into {$db->pre}spread_record (sid,ip,spend,word,addtime) values ($t,'$ip',$spend,'$kw',".time().")");

}

$is_validate = $db->get_one("select mid from {$db->pre}sogex_message where url = '$website_url' and is_validated = 1");
if($is_validate != false){
	header('Location: '.$u);
}else{
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />';
echo "<meta http-equiv='refresh' content='2;url=$u'>";
echo '<p>天成医搜正在为您跳转到其他网站，该网站未被天成认证...</p>';
}
?>
