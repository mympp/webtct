<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<div id="msgbox" onmouseover="closemsg();" style="display:none;"></div>
<div class="" onselectstart="return false" id="destoon_menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td width="10">&nbsp;</td>
<td id="Tab2" class="tab"><a href="?moduleid=4&file=vip" >Vip跟进服务</a></td><td width="10">&nbsp;</td>
<td id="Tab0" class="tab"><a href="?file=count" >管理员统计</a></td><td width="10">&nbsp;</td>
<td id="Tab1" class="tab"><a href="?file=count&type=allsite" >全站统计</a></td><td width="10">&nbsp;</td>
<td id="Tab3" class="tab"><a href="?file=count&action=date">数据统计</a></td>
</tr>
</table>
</div>
<div class="tt">搜索条件</div>
<form action="?">
<input type="hidden" name="action" value="date" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<table cellpadding="2" cellspacing="1" class="tb">
<?php
$ftime = date('Y-m-d',$fromtime);
$ttime = date('Y-m-d',$totime);
 ?>
<tr>
	<td width="25"></td>
	<td width="50">时间:</td>
	<td width="300"><?php echo dcalendar('fromtime', $ftime);?> 至 <?php echo dcalendar('totime', $ttime);?><br/></td>
	<td width="25"></td>
	<td><input type="submit" class="btn" value="确定" /></td>
</tr>
</table>
</form>
<div class="tt">统计结果：<?php echo date('Y-m-d H:i:s',$fromtime); ?> 至 <?php echo date('Y-m-d H:i:s',$totime); ?></div>
<table cellpadding="2" cellspacing="1" class="tb" align="center">
<tr>
	<th></th>
	<th>待审核/待回复</th>
	<th>已通过/已回复</th>
	<th>拒绝</th>
	<th>过期/下架</th>
	<th>删除</th>
	<th>总数</th>
</tr>
<?php 
	require_once DT_ROOT.'/include/tcdb.class.php';
	$tcdb = new tcdb('member');
	$count['status2'] = $tcdb->where(['regtime'=>$fromtime],'>')->where(['regtime'=>$totime],'<')->where(['groupid'=>4])->count('c');
	$count['status3'] = $tcdb->where(['regtime'=>$fromtime],'>')->where(['regtime'=>$totime],'<')->where(['groupid'=>4],'<>')->count('c');
	$count['total'] = $tcdb->where(['regtime'=>$fromtime],'>')->where(['regtime'=>$totime],'<')->count('c');
?>
<tr align="center" >
	<td>会员</td>
	<td><?php echo $count['status2']['c']; ?></td>
	<td><?php echo $count['status3']['c']; ?></td>
	<td>-</td>
	<td>-</td>
	<td>-</td>
	<td><?php echo $count['total']['c']; ?></td>
</tr>
<?php
	$table_name = ['mall','job','resume','brand_13','sell_5','buy_6','down_15','know','guestbook',];
	$module_name = ['产品','服务需求','工程师','品牌','供应','招标','资料共享','问答','留言'];
	foreach($table_name as $k =>$v){
		$count = [];
		$tcdb = new tcdb($v);
		$count['status2'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->where(['status'=>2])->count('c');
		$count['status3'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->where(['status'=>3])->count('c');
		$count['status1'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->where(['status'=>1])->count('c');
		$count['status4'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->where(['status'=>4])->count('c');
		$count['status0'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->where(['status'=>0])->count('c');
		$count['total'] = $tcdb->where(['edittime'=>$fromtime],'>')->where(['edittime'=>$totime],'<')->count('c');
?>
	<tr align="center" >
	<td><?php echo $module_name[$k]; ?></td>
	<td><?php echo $count['status2']['c']; ?></td>
	<td><?php echo $count['status3']['c']; ?></td>
	<td><?php echo $count['status1']['c']; ?></td>
	<td><?php echo $count['status4']['c']; ?></td>
	<td><?php echo $count['status0']['c']; ?></td>
	<td><?php echo $count['total']['c']; ?></td>
	</tr>
<?php 		
	}
	$table_name = ['comment','company_edit'];
	$module_name = ['评论','公司审核'];
	foreach($table_name as $k =>$v){
		$tcdb = new tcdb($v);
		$count['status2'] = $tcdb->where(['addtime'=>$fromtime],'>')->where(['addtime'=>$totime],'<')->where(['status'=>2])->count('c');
		$count['status3'] = $tcdb->where(['addtime'=>$fromtime],'>')->where(['addtime'=>$totime],'<')->where(['status'=>3])->count('c');
		$count['total'] = $tcdb->where(['addtime'=>$fromtime],'>')->where(['addtime'=>$totime],'<')->count('c');
?>
<tr align="center" >
<td><?php echo $module_name[$k]; ?></td>
<td><?php echo $count['status2']['c']; ?></td>
<td><?php echo $count['status3']['c']; ?></td>
<td>-</td>
<td>-</td>
<td>-</td>
<td><?php echo $count['total']['c']; ?></td>
</tr>
<?php 
	}
	$temporary_table = "(select * from (SELECT * FROM `tc_weixin_chat` where event = 0 and type <> 'push' and kefu_status <> 1 order by addtime desc) as temporary group by openid order by addtime desc)";	
	$condition = "t.type <> 'reply' ";
	$condition .= isset($totime) ? 'and t.addtime < '.$totime.' ' : '';
	$condition .= isset($fromtime) ? 'and t.addtime > '.$fromtime.' ' : '';
	$count = [];
	$count['status2'] = $db->get_one("select count(*) as c from $temporary_table as t where $condition");
	//var_dump("select count(*) as c from $temporary_table as t where $condition");
	//$temporary_table = "(select * from (SELECT * FROM `tc_weixin_chat` where event = 0 and type <> 'push' and kefu_status = 1 order by addtime desc) as temporary group by openid order by addtime desc)";	
	//$count['status3'] = $db->get_one("select count(*) as c from $temporary_table as t where $condition");
?>
<tr align="center" >
<td>微信回复</td>
<td><?php echo $count['status2']['c']; ?></td>
<td>-</td>
<td>-</td>
<td>-</td>
<td>-</td>
<td><?php echo ($count['status2']['c'] + $count['status3']['c']) ?></td>
</tr>
<?php 
	$count = [];
	$tcdb = new tcdb('mall_order');
	$count['status2'] = $tcdb->where(['updatetime'=>$fromtime],'>')->where(['updatetime'=>$totime],'<')->where(['kefu_status'=>0])->count('c');
	$count['status3'] = $tcdb->where(['updatetime'=>$fromtime],'>')->where(['updatetime'=>$totime],'<')->where(['kefu_status'=>1])->count('c');
?>
<tr align="center" >
<td>订单介入</td>
<td><?php echo $count['status2']['c']; ?></td>
<td><?php echo $count['status3']['c']; ?></td>
<td>-</td>
<td>-</td>
<td>-</td>
<td><?php echo ($count['status2']['c'] + $count['status3']['c']) ?></td>
</tr>
</table>

<script type="text/javascript">Menuon(3);</script>
<?php include tpl('footer');?>