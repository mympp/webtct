<?php
defined('DT_ADMIN') or exit('Access Denied');
global $db,$pagesize,$page;
$menus = array (
    array('审核企业设置', '?moduleid='.$moduleid.'&file=company_edit'),
);
$type = isset($type) ? $type : 1;
$page = isset($page) ? $page : 1;
$menuid = isset($menuid) ? $menuid : 0;
switch($action){
	case 'data':
		$company_edit = $db->query("select * from {$db->pre}company_edit_data where editid = $editid");
		$edit_data = array();
		while($r = $db->fetch_array($company_edit)){
			$edit_data[$r['item_key']] = $r['item_value'];
		}
		include tpl('company_edit_data',$module);
	break;
	case 'check':
		$feedback = isset($feedback) ? $feedback : '';
		$status = 3;
		$nowtime = time();
		$updateid = '';
		foreach($itemid as $k => $v){
			$updateid .= $v.',';
		}
		$updateid = substr($updateid,0,-1);
		
		//修改记录状态
		$db->query("update {$db->pre}company_edit set status = $status , feedback = '$feedback' , edittime = $nowtime where itemid in ($updateid)");
		//修改商家信息
		if($type == '1'){		//修改商家设置
			require_once DT_ROOT.'/module/member/global.func.php';
			foreach($itemid as $k =>$v){
				$company_edit_data = $db->query("select item_key,item_value from {$db->pre}company_edit_data where editid = $v");
				$setting = array();
				while($r = $db->fetch_array($company_edit_data)){
					$setting[$r['item_key']] = $r['item_value'];
				}
				//var_dump($userid[$k]);var_dump($setting);exit;
				update_company_setting($userid[$k],$setting);
			}
		}
		
		dmsg('审核成功!',"?moduleid=$moduleid&file=$file&type=$type");
	break;
	case 'reject':
		$feedback = isset($feedback) ? $feedback : '';
		$status = 1;
		$nowtime = time();
		$updateid = '';
		foreach($itemid as $k => $v){
			$updateid .= $v.',';
		}
		$updateid = substr($updateid,0,-1);
		
		//修改记录状态
		$db->query("update {$db->pre}company_edit set status = $status , feedback = '$feedback' , edittime = $nowtime where itemid in ($updateid)");
		dmsg('修改成功!',"?moduleid=$moduleid&file=$file&type=$type");
	break;
	default:
		$page = isset($page)?$page : 1;
		$start = ($page - 1)*$pagesize;
		$count = $db->get_one("select count(*) as c from {$db->pre}company_edit where status = 2 and type = $type");
		$company_edit = $db->query("select * from {$db->pre}company_edit where status = 2 and type = $type order by itemid desc limit $start,$pagesize");
		$pages = pages($count['c'],$page,$pagesize);
		include tpl('company_edit', $module);
}



?>