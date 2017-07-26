<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(4);</script>
<div class="tt">搜索规则管理</div>
<form action="?" method="post">
<input type="hidden" value="1" name="submit" />
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th width="12"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
	<th>等级</th>
	<th>网站</th>
	<th>域名</th>
	<th>规则类型</th>
	<th>作用分类</th>
	<th>作用词</th>
	<th>分数</th>
	<th>添加时间</th>
	<th>操作</th>
</tr>
<?php foreach($lists as $k=>$v) { ?>
<tr>
	<td align="center"><input type="checkbox" name="post[ruleid][]" value="<?php echo $v['ruleid']; ?>" /></td>
	<td align="center"><?php if($v['level']){echo '<img  src="admin/image/level_'.$v['level'].'.gif" />';} ?></td>
	<td align="center"><?php echo $v['web_name']; ?></td>
	<td align="center"><?php echo $v['web_url']; ?></td>
	<td align="center">
		 <?php echo $rule_type_arr[$v[type]]; ?>
	</td>
	<td align="center">
		<?php if($v['infotype']){echo $info_type_arr[$v['infotype']]['name'];}else{echo '所有类型';} ?>
	</td>
	<td align="center">
		<?php if($v['keyword']){echo $v['keyword']; }else{echo '所有词';}?>
	</td>
	<td align="center">
		<?php echo $v['score']; ?>
	</td>
	<td align="center">
		<?php echo date('Y-m-d',$v['addtime']); ?>
	</td>
	<td align="center">
		<a href="?file=<?php echo $file;?>&action=edit&ruleid=<?php echo $v['ruleid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
		<a href="?file=<?php echo $file;?>&action=delete&submit=1&ruleid=<?php echo $v['ruleid'];?>" onclick="return confirm('确定删除该信息?删除后不可找回!');"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
	</td>
</tr>
<?php } ?>
</table>
	<div class="pages"><?php echo $pages; ?></div>
	<div class="btns">
	<input type="submit" value="删除" class="btn" onclick="if(confirm('确定删除?删除后不可找回!')){this.form.action='?action=delete'}else{return false;}" />
	</div>
</form>

<?php include tpl('footer'); ?>