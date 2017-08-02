<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">自动回复</div>
<form action="?">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>回复内容</th>
	<th>当前状态</th>
	<th>操作</th>
</tr>
<?php foreach($type1_rules as $k=>$v){ ?>
<tr>
	<td align="center">
		<?php echo dsubstr(strip_tags($v['content']),120,'...'); ?>&nbsp;<a href="javascript:void();" onclick="Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_show&itemid=<?php echo $v['itemid'];?>','显示效果',250,300)" >[查看效果]</a>
	</td>
	<td width="80" align="center">
		<?php if($v['status'] == 3){echo '开启';}else{echo '关闭';} ?>
	</td>
	<td width="60" align="center">
		<a onclick="Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_edit&move=edit&itemid=<?php echo $v['itemid'];?>','修改规则')" href="javascript:void();"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>

	</td>
</tr>
<?php } ?>
</table>
</form>
<div class="tt">关键词规则</div>
<form action="?">
<table cellpadding="2" cellspacing="1" class="tb">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th style="min-width: 240px;">关键词</th>
	<th>回复内容</th>
	<th>当前状态</th>
	<th>操作</th>
</tr>
<?php foreach($type0_rules as $k=>$v){ ?>
<tr>
	<td align="center">
		<?php echo $v['keyword']; ?>
	</td>
	<td align="center">
		<?php echo dsubstr(strip_tags($v['content']),100,'...'); ?>&nbsp;<a href="javascript:void();" onclick="Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_show&itemid=<?php echo $v['itemid'];?>','显示效果',250,300)" >[查看效果]</a>
	</td>
	<td width="80" align="center">
		<?php if($v['status'] == 3){echo '开启';}else{echo '关闭';} ?>
	</td>
	<td width="60" align="center">
		<a onclick="Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_edit&move=edit&itemid=<?php echo $v['itemid'];?>','修改规则')" href="javascript:void();"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_edit&move=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
	</td>
</tr>
<?php } ?>

</table>
<div class="btns">
	<input type="buttom" onclick="Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reply_edit&move=add','添加规则')" name="" value="添加" class="btn" />
</div>
</form>
<script type="text/javascript">Menuon(6);</script>
<?php include tpl('footer');?>