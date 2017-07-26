<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(5);</script>
<div class="tt">数据分类</div>
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="submit" value="1" />
	<table cellpadding="2" cellspacing="1" class="tb">
		<tr>
			<th width="22px"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
			<th>分类id</td>
			<th>分类名</td>
			<th>分类英文名</th>
		</tr>
		<?php foreach($lists as $k=>$v){ ?>
		<tr align="center">
			<td><input type="checkbox" name="type[tid][]" value="<?php echo $v['tid']; ?>" /></td>
			<td><?php echo $v['catid']; ?></td>
			<td><input type="text" name="type[<?php echo $v['tid']; ?>][name]" value="<?php echo $v['name']; ?>" /></td>
			<td><input type="text" name="type[<?php echo $v['tid']; ?>][catname]" value="<?php echo $v['catname']; ?>" /></td>
		</tr>
		<?php } ?>
	</table>
<div class="btns">
<input type="submit" class="btn" value="更新" onclick="this.form.action='?action=update'" />&nbsp;&nbsp;<input type="submit" class="btn" value="删除" onclick="if(confirm('确定要删除该分类吗？删除会对数据造成影响')){this.form.action='?action=delete'}else{return false;}" />
</div>
</form>
<div class="tt">添加分类</div>
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="add" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>分类名</th>
<th>分类英文名</th>
<th>操作</th>
</tr>
<tr align="center">
<td><input type="text" name="name" value="" /></td>
<td><input type="text" name="catname" value="" /></td>
<td><input type="submit" value="添加" class="btn" /></td>
</tr>
</table>
</form>
<?php include tpl('footer'); ?>
