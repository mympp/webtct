<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(3);</script>
<div class="tt">查看用户反馈</div>
<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>用户ip</th>
	<th>用户名</th>
	<th>联系方式</th>
	<th>反馈内容</th>
	<th>反馈时间</th>
</tr>
<?php foreach($lists as $k => $v){ ?>
<tr align="center">
	<td><?php echo $v['ip']; ?></td>
	<td><?php echo $v['username']; ?></td>
	<td><?php echo $v['contact']; ?></td>
	<td>
	<?php echo dsubstr($v['content'],60,'...'); ?>&nbsp;&nbsp;<a href="javascript:void();" style="color:#2875b9" onclick="Dtip('<?php echo $v['content']; ?>','',3000)">[查看内容]</a></td>
	<td><?php echo date('Y-m-d H:i:s',$v['addtime']); ?></td>
</tr>
<?php } ?>
</table>
<div class="pages"><?php echo $pages; ?></div>
</form>
<?php include tpl('footer'); ?>