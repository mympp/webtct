<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(2);</script>
<div class="tt">查看搜索记录统计</div>
<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<input type="hidden" value="<?php echo $action; ?>" name="action" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
统计类型: 
<select name="stype" >
<option value="1" <?php if($stype == 1){ echo 'selected="selected"';} ?> >统计热搜词</option>
<option value="2" <?php if($stype == 2){ echo 'selected="selected"';} ?> >统计缺失词</option>	
</select>&nbsp;&nbsp;
搜索类型：<?php echo select_info_type('type','',$type); ?>&nbsp;&nbsp;
搜索时间：<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;&nbsp;
显示数目：<input type="text" name="num" value="<?php echo $num; ?>" />&nbsp;&nbsp;
<input type="reset" value="重置" class="btn" />&nbsp;<input type="submit" value="搜索" class="btn" />
</td>
</tr>
</table>
</form>
<br/>
<div>&nbsp;<?php echo date('Y-m-d H:i:s',$sfromdate); ?>&nbsp;至&nbsp;<?php echo date('Y-m-d H:i:s',$stodate); ?>&nbsp;的<?php if($stype == '1'){echo '热搜词';}else{echo '少搜索结果词汇';} ?>统计结果</div>
<br/>

<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<?php if($stype == '1'){ ?>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>搜索词</th>
	<th>搜索次数</th>
</tr>
<?php foreach($lists as $k => $v){ ?>
<tr align="center">
	<td><?php echo $v['word']; ?></td>
	<td><?php echo $v['census']; ?></td>
</tr>
<?php } ?>
</table>
<?php }else{ ?>
<table cellspacing="1" cellpadding="2" class="tb">
	<tr>
		<th>搜索词</th>
		<th>搜索类型</th>
		<th>搜索结果数目</th>
		<th>搜索时间</th>
	</tr>
<?php foreach($lists as $k=>$v){ ?>
	<tr align="center">
		<td><?php echo $v['word']; ?></td>
		<td><?php echo $info_type[$v['type']]['name']; ?></td>
		<td><?php echo $v['total']; ?></td>
		<td><?php echo date('Y-m-d  H:i:s',$v['addtime']) ?></td>
	</tr>
<?php } ?>
</table>
<?php } ?>
<div class="pages"><?php echo $pages; ?></div>
</form>
<?php include tpl('footer'); ?>