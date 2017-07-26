<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<div id="msgbox" onmouseover="closemsg();" style="display:none;"></div>
<div class="menu" onselectstart="return false" id="destoon_menu">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="bottom">
<table cellpadding="0" cellspacing="0">
<tr>
<td width="10">&nbsp;</td>
<td id="Tab2" class="tab"><a href="?moduleid=4&file=vip" >Vip跟进服务</a></td><td width="10">&nbsp;</td>
<td id="Tab0" class="tab"><a href="?file=count" >管理员统计</a></td><td width="10">&nbsp;</td>
<td id="Tab1" class="tab"><a href="?file=count&type=allsite" >全站统计</a></td><td width="10">&nbsp;</td>
<td id="Tab3" class="tab"><a href="?file=count&action=date">数据统计</a></td>
</tr>
</table>
</td>
<td width="110"><div><img src="admin/image/spacer.gif" width="40" height="24" title="刷新" onclick="window.location.reload();" style="cursor:pointer;" alt=""/><img src="admin/image/spacer.gif" width="20" height="24" title="后退" onclick="history.back(-1);" style="cursor:pointer;" alt=""/><img src="admin/image/spacer.gif" width="20" height="24" title="前进" onclick="history.go(1);" style="cursor:pointer;" alt=""/><img src="admin/image/spacer.gif" width="20" height="24" title="帮助" onclick="Go('http://www.destoon.com/client.php?action=help&product=b2b&mfa=destoon-count-');" style="cursor:help;" alt=""/></div></td>
</tr>
</table>
</div>
<form action="?">
<div class="tt">统计报表</div>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<select name="mid">
<?php
	foreach($MODULE as $m) {
	if(!in_array($m['moduleid'], array(1,3,4)) && !$m['islink']) {
?>
<option value="<?php echo $m['moduleid'];?>"<?php echo $mid == $m['moduleid'] ? ' selected' : ''?>><?php echo $m['name'];?></option>
<?php } } ?>
</select>&nbsp;
<select name="year">
<option value="0">选择年</option>
<?php for($i = date("Y", $DT_TIME); $i >= 2000; $i--) { ?>
<option value="<?php echo $i;?>"<?php echo $i == $year ? ' selected' : ''?>><?php echo $i;?>年</option>
<?php } ?>
</select>&nbsp;
<select name="month">
<option value="0">选择月</option>
<?php for($i = 1; $i < 13; $i++) { ?>
<option value="<?php echo $i;?>"<?php echo $i == $month ? ' selected' : ''?>><?php echo $i;?>月</option>
<?php } ?>
</select>&nbsp;
<input type="submit" value="生成报表" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>&action=<?php echo $action;?>&mid=<?php echo $mid;?>&itemid=<?php echo $itemid;?>');"/>
</td>
</tr>
</table>
</form>
<?php
	if($year && $month && $mid) {
	$tb = get_table($mid);
	if($tb=="{$db->pre}hr") $tb="{$db->pre}hr_job";  //人才招聘对应统计表应该为 tc_hr_job
	$fd = 'addtime';
	$ym = $year.'-'.$month;
	if($mid == 2) $fd = 'regtime';
	$d = date('t', strtotime($ym.'-1'));
	$chart_data = '';
	for($i = 1; $i <= $d; $i++) {
		$f = strtotime($ym.'-'.$i.' 00:00:00');
		$t = strtotime($ym.'-'.$i.' 23:59:59');
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$tb} WHERE `$fd`>=$f AND `$fd`<=$t");
		if($i > 1) $chart_data .= '\n';
		$chart_data .= $i.';'.($r['num'] ? $r['num'] : 0);
	}
?>
<div class="tt"><?php echo $MODULE[$mid]['name'];?> <?php echo $year;?>年<?php echo $month;?>月统计报表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td style="padding:10px;">
<?php load('swfobject.js');?>
<script type="text/javascript" src="<?php echo DT_PATH;?>api/amcharts/amcharts.js"></script>
<script type="text/javascript" src="<?php echo DT_PATH;?>api/amcharts/amfallback.js"></script>
<div id="chartdiv" style="width:700px;height:400px;background:#FFFFFF;"></div>        
<script type="text/javascript">
var params = 
{
	bgcolor:"#FFFFFF"
};	
var flashVars = 
{
	path: "<?php echo DT_PATH;?>api/amcharts/flash/",		
	chart_data: "<?php echo $chart_data;?>",
	chart_settings: "<settings><data_type>csv</data_type><plot_area><margins><left>50</left><right>40</right><top>50</top><bottom>50</bottom></margins></plot_area><grid><category><dashed>1</dashed><dash_length>4</dash_length></category><value><dashed>1</dashed><dash_length>4</dash_length></value></grid><axes><category><width>1</width><color>E7E7E7</color></category><value><width>1</width><color>E7E7E7</color></value></axes><values><value><min>0</min></value></values><legend><enabled>0</enabled></legend><angle>0</angle><column><width>85</width><balloon_text>{title}:{value}</balloon_text><grow_time>3</grow_time><sequenced_grow>1</sequenced_grow></column><graphs><graph gid='0'><title>总数</title><color>7F8DA9</color></graph></graphs><labels><label lid='0'><text><![CDATA[<b><?php echo $MODULE[$mid]['name'];?><?php echo $year;?>年<?php echo $month;?>月统计报表</b>]]></text><y>18</y><text_color>000000</text_color><text_size>13</text_size><align>center</align></label></labels></settings>"
};
if (swfobject.hasFlashPlayerVersion("8")) {
	swfobject.embedSWF("<?php echo DT_PATH;?>api/amcharts/flash/amcolumn.swf", "chartdiv", "700", "400", "8.0.0", "<?php echo DT_PATH;?>api/amcharts/flash/expressInstall.swf", flashVars, params);
} else {
	var amFallback = new AmCharts.AmFallback();
	amFallback.chartSettings = flashVars.chart_settings;
	amFallback.pathToImages = "<?php echo DT_PATH;?>api/amcharts/images/";
	amFallback.chartData = flashVars.chart_data;
	amFallback.type = "column";
	amFallback.write("chartdiv");
}
</script>
</td>
</tr>
</table>
<?php
	} else if($year && $mid) {
	$tb = get_table($mid);
	if($tb=="{$db->pre}hr") $tb="{$db->pre}hr_job";  //人才招聘对应统计表应该为 tc_hr_job
	$fd = 'addtime';
	$ym = $year;
	if($mid == 2) $fd = 'regtime';
	$chart_data = '';
	for($i = 1; $i < 13; $i++) {		
		$f = strtotime($ym.'-'.$i.'-1 00:00:00');
		$d = date('t', $f);
		$t = strtotime($ym.'-'.$i.'-'.$d.' 23:59:59');
		$r = $db->get_one("SELECT COUNT(*) AS num FROM {$tb} WHERE `$fd`>=$f AND `$fd`<=$t");
		if($i > 1) $chart_data .= '\n';
		$chart_data .= $i.';'.($r['num'] ? $r['num'] : 0);
	}
?>
<div class="tt"><?php echo $MODULE[$mid]['name'];?> <?php echo $year;?>年统计报表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td style="padding:10px;">
<?php load('swfobject.js');?>
<script type="text/javascript" src="<?php echo DT_PATH;?>api/amcharts/amcharts.js"></script>
<script type="text/javascript" src="<?php echo DT_PATH;?>api/amcharts/amfallback.js"></script>
<div id="chartdiv" style="width:700px;height:400px;background:#FFFFFF;"></div>        
<script type="text/javascript">
var params = 
{
	bgcolor:"#FFFFFF"
};	
var flashVars = 
{
	path: "<?php echo DT_PATH;?>api/amcharts/flash/",		
	chart_data: "<?php echo $chart_data;?>",
	chart_settings: "<settings><data_type>csv</data_type><plot_area><margins><left>50</left><right>40</right><top>50</top><bottom>50</bottom></margins></plot_area><grid><category><dashed>1</dashed><dash_length>4</dash_length></category><value><dashed>1</dashed><dash_length>4</dash_length></value></grid><axes><category><width>1</width><color>E7E7E7</color></category><value><width>1</width><color>E7E7E7</color></value></axes><values><value><min>0</min></value></values><legend><enabled>0</enabled></legend><angle>0</angle><column><width>85</width><balloon_text>{title}:{value}</balloon_text><grow_time>3</grow_time><sequenced_grow>1</sequenced_grow></column><graphs><graph gid='0'><title>总数</title><color>7F8DA9</color></graph></graphs><labels><label lid='0'><text><![CDATA[<b><?php echo $MODULE[$mid]['name'];?><?php echo $year;?>年统计报表</b>]]></text><y>18</y><text_color>000000</text_color><text_size>13</text_size><align>center</align></label></labels></settings>"
};
if (swfobject.hasFlashPlayerVersion("8")) {
	swfobject.embedSWF("<?php echo DT_PATH;?>api/amcharts/flash/amcolumn.swf", "chartdiv", "700", "400", "8.0.0", "<?php echo DT_PATH;?>api/amcharts/flash/expressInstall.swf", flashVars, params);
} else {
	var amFallback = new AmCharts.AmFallback();
	amFallback.chartSettings = flashVars.chart_settings;
	amFallback.pathToImages = "<?php echo DT_PATH;?>api/amcharts/images/";
	amFallback.chartData = flashVars.chart_data;
	amFallback.type = "column";
	amFallback.write("chartdiv");
}
</script>
</td>
</tr>
</table>
<?php } else { 
	
if(!$_REQUEST['type']){?>
<style type="text/css">
	.tl{width:100px;}
</style>

<div class="tt">后台管理员概况</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width=100>账号</th>
<th width=280>站内信</th>
<th width=230>订单待处理</th>
<th >服务需求状态</th>
</tr>
<tr>
<td>全站</td>
<td>所有邮件<a href="?moduleid=2&file=message&&touser="><span id="site_message"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>&nbsp;&nbsp;&nbsp;未读邮件<a href="?moduleid=2&file=message&typeid=-1&read=0&send=-1&touser="><span id="to_site_message_noread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>&nbsp;&nbsp;</td>
<td>
逾期确认<a href="?moduleid=16&file=order&over_check=1&kefu_status=0"><span id="site_order_seller"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;逾期完成<a href="?moduleid=16&file=order&over_finish=1&kefu_status=0"><span id="site_order_buyer"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td>总数<a href="?moduleid=9&username="><span id="site_job"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;未报名<a href="?moduleid=9&username=&apply=0&dengyu=%3D"><span id="site_job_apply"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;有报名未选定<a href="?moduleid=9&file=resume&username=&order=12"><span id="site_job_step"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;从未被选定简历<a href="?moduleid=9&file=resume&username=&order=12&talent=0&dengyu=%3D"><span id="site_job_talent"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;报名未跟进<a href="?moduleid=9&file=apply&type=noadmin"><span id="site_job_apply_noadmin"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
</td>
</tr>

<?php $userlist=getsqldata("username","{$db->pre}member","groupid=1 ",10);
 foreach($userlist as $k => $v) { ?>
<tr>
<td><?php echo $v['username'];?></td>
<td>所有邮件<a href="?moduleid=2&file=message&&touser=<?php echo $v['username'];?>"><span id="<?php echo $v['username'];?>_message"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>&nbsp;&nbsp;&nbsp;未读收件<a href="?moduleid=2&file=message&typeid=-1&read=0&send=-1&touser=<?php echo $v['username'];?>"><span id="to_<?php echo $v['username'];?>_message_noread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>&nbsp;&nbsp;未读发件<a href="?moduleid=2&file=message&typeid=-1&read=0&send=-1&fromuser=<?php echo $v['username'];?>"><span id="from_<?php echo $v['username'];?>_message_noread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td>
等卖家确认<a href="?moduleid=16&file=order&status=0&seller=<?php echo $v['username'];?>"><span id="<?php echo $v['username'];?>_order_seller"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;等买家付款<a href="?moduleid=16&file=order&status=1&buyer=<?php echo $v['username'];?>"><span id="<?php echo $v['username'];?>_order_buyer"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td>总数<a href="?moduleid=9&username=<?php echo $v['username'];?>"><span id="<?php echo $v['username'];?>_job"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;未报名<a href="?moduleid=9&username=<?php echo $v['username'];?>&apply=0&dengyu=%3D"><span id="<?php echo $v['username'];?>_job_apply"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;有报名未选定<a href="?moduleid=9&file=resume&username=<?php echo $v['username'];?>&order=12"><span id="<?php echo $v['username'];?>_job_step"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;从未被选定简历<a href="?moduleid=9&file=resume&username=<?php echo $v['username'];?>&talent=0&dengyu=%3D"><span id="<?php echo $v['username'];?>_job_talent"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;&nbsp;&nbsp;报名未跟进<a href="?moduleid=9&file=apply&type=noadmin&job_username=<?php echo $v['username'];?>"><span id="<?php echo $v['username'];?>_job_apply_noadmin"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>


</td>
</tr>
<?php }?>
</table>

<div class="tt">网站数据待处理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width=100>功能</th>
<th>
项目内容
</th>
</tr>
<tr>
<td width=100>审核</td>
<td>
&nbsp;会员<a href="?moduleid=2&action=check"><span id="member_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;需求<a href="?moduleid=9&action=check"><span id="m_9_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;工程师<a href="?moduleid=9&file=resume&action=check"><span id="m_resume_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;品牌<a href="?moduleid=13&action=check"><span id="m_13_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;产品<a href="?moduleid=16&action=check"><span id="m_16_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;供应<a href="?moduleid=5&action=check"><span id="m_5_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;求购<a href="?moduleid=6&action=check"><span id="m_6_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;资讯<a href="?moduleid=21&action=check"><span id="m_21_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;团购<a href="?moduleid=17&action=check"><span id="m_17_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;下载<a href="?moduleid=15&action=check"><span id="m_15_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;分享<a href="?moduleid=10&action=check"><span id="m_10_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;回帖<a href="?moduleid=10&file=answer&action=check"><span id="answer"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;评论<a href="?moduleid=3&file=comment&action=check"><span id="comment"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;留言<a href="?moduleid=3&file=guestbook"><span id="guestbook"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;微信待回复<a href="?moduleid=2&file=weixin&action=wait"><span id="weixin"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;公司审核<a href="?moduleid=4&file=company_edit"><span id="company_edit"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计" /></span></a>
</td>
</tr>
<tr>
<td width=100>处理</td>
<td>
&nbsp;没LOGO没处理的网店<a href="?moduleid=4&thumb=2&nocatids=1"><span id="companyl"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待转化网店<a href="?moduleid=4&nocatids=1"><span id="companyz"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;QQ群信息未处理<a href="?moduleid=3&file=taoxinxi&order=0&psize=20"><span id="taoxinxi2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;会员升级申请<a href="?moduleid=2&file=grade&action=check"><span id="member_upgrade"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待受理客服中心<a href="?moduleid=2&file=ask&status=0"><span id="ask"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待受理在线充值<a href="?moduleid=2&file=charge&status=0"><span id="charge"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待受理资金提现<a href="?moduleid=2&file=cash&status=0"><span id="cash"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待受理会员交易<a href="?moduleid=16&file=order"><span id="trade"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
</td>
</tr>
<tr>
<td width=100>更多</td>
<td>
&nbsp;待审核贸易提醒<a href="?moduleid=2&file=alert&action=check"><span id="alert"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核友情链接<a href="?moduleid=3&file=link&action=check"><span id="link"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核公司新闻<a href="?moduleid=2&file=news&action=check"><span id="news"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核荣誉资质<a href="?moduleid=2&file=honor&action=check"><span id="honor"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核单页宣传<a href="?moduleid=2&file=page&action=check"><span id="pages"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核公司链接<a href="?moduleid=2&file=link&action=check"><span id="comlink"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核搜索关键词<a href="?file=keyword&status=2"><span id="keyword"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审实名认证<a href="?moduleid=2&file=validate&status=2"><span id="validate"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审广告购买<a href="?moduleid=3&file=ad&action=list&job=check"><span id="ad"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
&nbsp;待审核排名推广<a href="?moduleid=3&file=spread&action=check"><span id="spread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a>
</td>
</tr>
</table>
<?php
}
if($_REQUEST['type']){?>
<div class="tt">统计概况</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td ><a href="?moduleid=2&file=ask" class="t">待受理客服中心</a></td>
<td>&nbsp;<a href="?moduleid=2&file=ask&status=0"><span id="ask"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=charge&status=0" class="t">待受理在线充值</a></td>
<td>&nbsp;<a href="?moduleid=2&file=charge&status=0"><span id="charge"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=cash&status=0" class="t">待受理资金提现</a></td>
<td>&nbsp;<a href="?moduleid=2&file=cash&status=0"><span id="cash"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=16&file=order&status=5" class="t">待受理会员交易</a></td>
<td>&nbsp;<a href="?moduleid=16&file=order"><span id="trade"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=17&file=order&status=4" class="t">待受理团购交易</a></td>
<td>&nbsp;<a href="?moduleid=17&file=order&status=4"><span id="group"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td ><a href="?moduleid=2&file=alert&action=check" class="t">待审核贸易提醒</a></td>
<td>&nbsp;<a href="?moduleid=2&file=alert&action=check"><span id="alert"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=3&file=guestbook" class="t">待回复网站留言</a></td>
<td>&nbsp;<a href="?moduleid=3&file=guestbook"><span id="guestbook"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=3&file=comment&action=check" class="t">待审核评论</a></td>
<td>&nbsp;<a href="?moduleid=3&file=comment&action=check"><span id="comment"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=3&file=link&action=check" class="t">待审核友情链接</a></td>
<td>&nbsp;<a href="?moduleid=3&file=link&action=check"><span id="link"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td ><a href="?moduleid=2&file=news&action=check" class="t">待审核公司新闻</a></td>
<td>&nbsp;<a href="?moduleid=2&file=news&action=check"><span id="news"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=2&file=honor&action=check" class="t">待审核荣誉资质</a></td>
<td>&nbsp;<a href="?moduleid=2&file=honor&action=check"><span id="honor"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=2&file=link&action=check" class="t">待审核公司链接</a></td>
<td>&nbsp;<a href="?moduleid=2&file=link&action=check"><span id="comlink"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?file=keyword&status=2" class="t">待审核搜索关键词</a></td>
<td>&nbsp;<a href="?file=keyword&status=2"><span id="keyword"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td ><a href="?moduleid=2&file=validate&status=2" class="t">待审实名认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=member"><span id="edit_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=3&file=ad&action=list&job=check" class="t">待审广告购买</a></td>
<td>&nbsp;<a href="?moduleid=3&file=ad&action=list&job=check"><span id="ad"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=3&file=spread&action=check" class="t">待审核排名推广</a></td>
<td>&nbsp;<a href="?moduleid=3&file=spread&action=check"><span id="spread"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td class="tl"><a href="?moduleid=2&file=validate&action=company&status=2" class="t">待审公司认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=company&status=2"><span id="vcompany"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=truename&status=2" class="t">待审实名认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=truename&status=2"><span id="vtruename"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=mobile&status=2" class="t">待审手机认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=mobile&status=2"><span id="vmobile"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=validate&action=email&status=2" class="t">待审邮件认证</a></td>
<td>&nbsp;<a href="?moduleid=2&file=validate&action=email&status=2"><span id="vemail"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td class="tl"><a href="?moduleid=18&file=group&action=check" class="t">待审商圈申请</a></td>
<td>&nbsp;<a href="?moduleid=18&file=group&action=check"><span id="club_group"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=18&file=reply&action=check" class="t">待审商圈回复</a></td>
<td>&nbsp;<a href="?moduleid=18&file=reply&action=check"><span id="club_reply"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=18&file=fans&action=check" class="t">待审商圈粉丝</a></td>
<td>&nbsp;<a href="?moduleid=18&file=fans&action=check"><span id="club_fans"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=10&file=answer&action=check" class="t">待审核知道回答</a></td>
<td>&nbsp;<a href="?moduleid=10&file=answer&action=check"><span id="answer"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<tr>
<td class="tl"><a href="?moduleid=7&file=price&action=check" class="t">待审产品报价</a></td>
<td>&nbsp;<a href="?moduleid=7&file=price&action=check"><span id="quote_price"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td class="tl"><a href="?moduleid=2&file=grade&action=check" class="t">会员升级申请</a></td>
<td>&nbsp;<a href="?moduleid=2&file=grade&action=check"><span id="member_upgrade"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=2&file=grade&action=check" class="t">QQ群信息统计</a></td>
<td>&nbsp;<a href="?moduleid=3&file=taoxinxi"><span id="taoxinxi"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
<td ><a href="?moduleid=2&file=grade&action=check" class="t">QQ群信息未处理</a></td>
<td>&nbsp;<a href="?moduleid=3&file=taoxinxi&order=0&psize=20"><span id="taoxinxi2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<tr>
<td ><a href="?moduleid=2" class="t">会员</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td ><a href="?moduleid=4&file=vip" class="t"><?php echo VIP;?>会员</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4&file=vip"><span id="member_vip"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td ><a href="?moduleid=2&action=check" class="t">待审核</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2&action=check"><span id="member_check"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>


<td ><a href="?moduleid=2&action=add" class="t">今日新增</a></td>

<td width="10%">&nbsp;<a href="?moduleid=2"><span id="member_new"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>
<tr>
<td ><a href="?moduleid=4" class="t">网店</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4"><span id="companyc"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td ><a href="?moduleid=4&dzh=1" class="t">待转化</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4&dzh=1"><span id="companyz"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td ><a href="?moduleid=4&thumb=2" class="t">没LOGO的</a><a href="?moduleid=4&thumb=2"><span id="companyl"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td width="10%">&nbsp;有LOGO<a href="?moduleid=4&thumb=1"><span id="companyy"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>


<td ><a href="?moduleid=4&closeshop=1" class="t">关闭的</a></td>

<td width="10%">&nbsp;<a href="?moduleid=4&closeshop=1"><span id="companyg"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<?php
foreach ($MODULE as $m) {
	if($m['moduleid'] < 5 || $m['islink']) continue;
?>

<?php 
if($m['moduleid'] == 9) $m['name'] = '服务需求';
?>

<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" class="t" target="_blank"><?php echo $m['name'];?></a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>" class="t">已发布</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_1"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=check" class="t">待审核</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&action=check"><span id="m_<?php echo $m['moduleid'];?>_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&action=add" class="t">今日新增</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_<?php echo $m['moduleid'];?>_3"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>


<?php
if($m['moduleid'] == 9) {
	$m['name'] = '供应商';
?>
<tr>
<td class="tl"><a href="<?php echo $m['linkurl'];?>" class="t" target="_blank"><?php echo $m['name'];?></a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume"><span id="m_resume"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume" class="t">已发布</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume"><span id="m_resume_1"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=check" class="t">待审核</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=check"><span id="m_resume_2"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>

<td class="tl"><a href="?moduleid=<?php echo $m['moduleid'];?>&file=resume&action=add" class="t">今日新增</a></td>

<td>&nbsp;<a href="?moduleid=<?php echo $m['moduleid'];?>"><span id="m_resume_3"><img src="admin/image/count.gif" width="10" height="10" alt="正在统计"/></span></a></td>
</tr>

<?php } ?>

<?php
}
?>
</table>
<?php } 
}
?>
<?php if($_REQUEST['type']){?><script type="text/javascript">Menuon(1);</script><?php }else{?><script type="text/javascript">Menuon(0);</script><?php } ?>
<script type="text/javascript" src="?file=<?php echo $file;?>&action=js&type=<?php echo $type;?>"></script>
<?php include tpl('footer');?>