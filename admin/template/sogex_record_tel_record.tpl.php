<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(4);</script>
<div class="tt">查看客服电话点击统计</div>
<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<input type="hidden" value="<?php echo $action; ?>" name="action" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;&nbsp;
电话号码:<input type="text" name="telephone" value="<?php echo $telephone; ?>" /> &nbsp;&nbsp;
点击时间：<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;&nbsp;
<input type="reset" value="重置" class="btn" />&nbsp;<input type="submit" value="搜索" class="btn" />
</td>
</tr>
</table>
</form>
<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>电话标题</th>
	<th>用户名</th>
	<th>用户ip</th>
	<th>来源地址</th>
	<th>被点击电话</th>
	<th>点击时间</th>
</tr>
<?php foreach($lists as $k => $v){ ?>
<tr align="center">
	<td><?php echo $v['title']; ?></td>
	<td><?php echo $v['username']; ?></td>
	<td><?php echo $v['ip']; ?></td>
	<td><?php echo $v['fromurl']; ?></td>
	<td><?php echo $v['telephone']; ?></td>
	<td><?php echo date('Y-m-d H:i:s',$v['addtime']); ?></td>
</tr>
<?php } ?>
</table>
<div class="pages">记录总数目:<?php echo $count['c']; ?>&nbsp;&nbsp;<?php echo $pages; ?></div>
</form>
<?php include tpl('footer'); ?>