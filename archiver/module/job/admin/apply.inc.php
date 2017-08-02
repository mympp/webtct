<?php
defined('DT_ADMIN') or exit('Access Denied');
require MD_ROOT.'/job.class.php';
$do = new job($moduleid);
global $MOD, $pages, $page, $pagesize, $offset, $CATEGORY, $items, $sum,$DT_PRE;
$menus = array (
    array('最新报名列表', '?file=apply&moduleid='.$moduleid),
    array('已选定报名列表', '?file=apply&type=apply&moduleid='.$moduleid),
    array('管理员未跟进报名列表', '?file=apply&type=noadmin&moduleid='.$moduleid),
    array('管理员已跟进列表', '?file=apply&type=admin&moduleid='.$moduleid)
);

switch($action) {
	case 'delete':
		$jobid or msg('请选择'.$MOD['name']);
        $db->query("delete from {$DT_PRE}_job_apply  WHERE applyid=$applyid");
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}job_apply WHERE jobid=$jobid");//获取服务需求的报名总数
		$db->query("UPDATE {$DT_PRE}job SET apply=$r[num] WHERE itemid=$jobid");//更新报名需求统计
		echo "<script>alert('删除成功！')</script>";exit;
	break;
	case 'update':
		$applyid or msg('请选择'.$MOD['name']);
        $db->query("UPDATE ".$DT_PRE."job_apply SET status=2,updatetime='$DT_TIME' WHERE jobid=$jobid and status=3");
        $db->query("UPDATE ".$DT_PRE."job_apply SET status=$status,updatetime='$DT_TIME',adminnote='$adminnote' WHERE applyid=$applyid");
		echo "<script>alert('更新信息情况成功！')</script>";exit;
	break;
	default:
		$menuid = 0;
	    $condition=' and a.applyid>0';
        if($type=='apply'){$condition .=' and a.applyid>0';$menuid = 1;}
        if($type=='noadmin'){$condition .=' and a.admin=0';$menuid = 2;}
        if($type=='admin'){$condition .=' and a.admin=1';$menuid = 3;}
        if($job_username){$condition .=" and a.job_username='$job_username'";}
        if($apply_username){$condition .=" and a.apply_username='$apply_username'";}
        if($status){$condition .=" and a.status=$status";}
		$lists = $do->get_apply_list($condition);
		include tpl('apply', $module);
	break;
}
?>