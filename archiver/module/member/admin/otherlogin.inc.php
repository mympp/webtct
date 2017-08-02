<?php
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
    array('第三方用户列表', '?moduleid='.$moduleid.'&file='.$file),
    array('添加第三方用户', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
);
switch($action) {
	case 'add':
		if($submit){
			if(!is_array($_POST)) return false;
			if(!$_POST['webname']) dmsg('网站名不能为空', $forward);
			if(!$_POST['weburl']) dmsg('网站地址不能为空', $forward);
			if(!$_POST['callback']) dmsg('回调地址不能为空', $forward);
			$webname  = $_POST['webname'];
			$weburl   = $_POST['weburl'];
			$callback = $_POST['callback'];
			$scope = "get_user_info";
			if($_POST['scope']){
				for($i=0;$i<count($_POST['scope']);$i++){
					$scope .= ','.$_POST['scope'][$i];
				}
			}
			//随机生成一个client_id和client_screct
			$round = "abcdefghjkmnpqrstuvwxyz23456789";
			$len   = strlen($round);
			$j     = 0;
			for($i = 0; $i < 10;$i++){
				//最多随机生成10次，若都重复，返回错误
				$strclient = '';
				for($i = 0;$i < 16;$i++){
					$num = mt_rand(0, $len-1);
					$strclient .= $round[$num];
				}
				//查询该clientid是否存在
				$r = $db->get_one("SELECT client_id  FROM oauth_clients where client_id = '".$strclient."' limit 1");
				if(!$r){
					break;
				}else{
					$j++;
				}
			}
			if($j == 10){
				dmsg('添加失败，请稍后再试', $forward);
			}
			$strsecret = '';
			for($i = 0;$i < 32;$i++){
				$num = mt_rand(0, $len-1);
				$strsecret .= $round[$num];
			}
			$fields  = "client_id,client_secret,redirect_uri,grant_types,scope,client_name,client_url,add_time,add_user";
			$now     = date('Y-m-d H:i:s');
			$values = "'$strclient','$strsecret','$callback','authorization_code','$scope','$webname','$weburl','$now','$_username'";
			$db->query("INSERT INTO oauth_clients($fields) VALUES ($values)");
			dmsg('添加成功', $forward);
		}else{
			//读取权限列表
			include tpl('otherlogin_add', $module);
		}
		break;
	case 'edit':
		if($submit){
			if(!is_array($_POST)) return false;
			if(!$_POST['webname']) dmsg('网站名不能为空', $forward);
			if(!$_POST['weburl']) dmsg('网站地址不能为空', $forward);
			if(!$_POST['callback']) dmsg('回调地址不能为空', $forward);
			$webname  = $_POST['webname'];
			$weburl   = $_POST['weburl'];
			$callback = $_POST['callback'];
			$clientid = $_POST['clientid'];
			$scope = "get_user_info";
			if($_POST['scope']){
				for($i=0;$i<count($_POST['scope']);$i++){
					$scope .= ','.$_POST['scope'][$i];
				}
			}
			$db->query("update oauth_clients set client_name = '{$webname}',client_url = '{$weburl}',redirect_uri = '{$callback}',scope='{$scope}' where client_id = '{$clientid}'");
			dmsg('修改成功', $forward);
		}else{
			$clientId = $_GET['clientid'];
			$result = $db->query("SELECT * FROM oauth_clients WHERE client_id = '{$clientId}'");
			while($r = $db->fetch_array($result)) {
				$members[] = $r;
			}
			include tpl('otherlogin_edit', $module);
		}
		break;
	case 'resetsec':
			$clientId = $_GET['clientid'];
			//随机生成一个client_screct
			$round = "abcdefghjkmnpqrstuvwxyz23456789";
			$len   = strlen($round);
			$strsecret = '';
			for($i = 0;$i < 32;$i++){
				$num = mt_rand(0, $len-1);
				$strsecret .= $round[$num];
			}
			$db->query("update oauth_clients set client_secret = '{$strsecret}' where client_id = '{$clientId}'");
			dmsg('重置成功', $forward);

		break;
	case 'delete':
		$clientid or msg('请选择记录');
		if(is_array($clientid)){
			$len = count($clientid);
			$ids = '';
			for($i=0;$i<$len;$i++){
				$ids .= ","."'".$clientid[$i]."'";
			}
			$ids = trim($ids,',');
		}else{
			$ids = "'".$clientid."'";
		}
		$db->query("DELETE FROM oauth_clients WHERE client_id IN ($ids)");
		$db->query("DELETE FROM oauth_access_tokens WHERE client_id IN ($ids)");
		$db->query("DELETE FROM oauth_authorization_codes WHERE client_id IN ($ids)");
		$db->query("DELETE FROM oauth_refresh_tokens WHERE client_id IN ($ids)");
		dmsg('删除成功', $forward);
		include tpl('otherlogin', $module);
		break;
	break;
	default:
		$sfields = array('按条件', '网站名称','网址');
		$dfields = array('client_name', 'client_name', 'client_url');
		$sorder  = array('结果排序方式', '添加时间降序', '添加时间升序');
		$dorder  = array('add_time DESC', 'add_time DESC', 'add_time ASC');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		isset($site) or $site = '';
		isset($order) && isset($dorder[$order]) or $order = 0;
		$thumb = isset($thumb) ? intval($thumb) : 0;
		$link = isset($link) ? intval($link) : 0;
		$fields_select = dselect($sfields, 'fields', '', $fields);
		$order_select  = dselect($sorder, 'order', '', $order);
		$condition = '1';
		if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
		$order = $dorder[$order];
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = $db->get_one("SELECT COUNT(*) AS num FROM oauth_clients WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);
		$members = array();
		$result = $db->query("SELECT * FROM oauth_clients WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result)) {
			$members[] = $r;
		}
		include tpl('otherlogin', $module);
	break;
}
?>